<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Indent;
use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @Route("/admin/", name="adminHome")
     */
    public function indexAction(){
        $theIndent = $this->getAllOrder();
        $inOrder = $this->getAllCartByOrder();
        return $this->render('admin/index.html.twig', ['listOrder' => $theIndent, 'listInOrder' => $inOrder]);
    }
    
    private function getAllOrder(){
        $em = $this->getDoctrine()->getManager();
        $queryIndent = $em->createQuery('SELECT i FROM AppBundle:Indent i');
        $listIndent = $queryIndent->execute();
        return $listIndent;
    }
    
    private function getAllCartByOrder(){
        $em = $this->getDoctrine()->getManager();
        $theIndent = $this->getAllOrder();
        $inOrder = array();
        foreach ($theIndent as $indent) {
            $cart = $indent->getCart();
            $inOrder[$indent->getId()] = $cart->getRows();
        }
        return $inOrder;
    }
    
    /**
     * @Route("/admin/delOrder/{id}", name="adminDelOrder")
     */
    public function delOrderAction($id){
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository(Indent::class)->findOneById($id);
        $cart = $order->getCart();
        foreach ($cart->getRows() as $row) {
            $cart->removeRow($row);
            $em->remove($row);
            $em->flush();
        }
        $em->remove($cart);
        $em->remove($order);
        $em->flush();
        return $this->redirectToRoute('adminHome');
    }
    
    /**
     * @Route("/admin/gestProd", name="gestProd")
     */
    public function gestProdAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $theProd = $this->getAllProd();
        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);
        $formEdit = $this->createTheFormEdit($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $file = $data->getPicture();
            switch($request->request->get('selectCategory')){
                case 'Plante':{
                    $fileName = 'pla_'.$file->getClientOriginalName();
                    $cat = $em->getRepository(Category::class)->findOneById(1);
                    break;
                }
                case 'Fleur':{
                    $fileName = 'fle_'.$file->getClientOriginalName();
                    $cat = $em->getRepository(Category::class)->findOneById(3);
                    break;
                }
                case 'Composition':{
                    $fileName = 'com_'.$file->getClientOriginalName();
                    $cat = $em->getRepository(Category::class)->findOneById(2);
                    break;
                }
            }
            $file->move($this->getParameter('photos_directory'), $fileName);
            $data->setPicture('/products/'.$fileName);
            $data->setCategory($cat);
            $em->persist($data);
            $em->flush();
            return $this->redirectToRoute('gestProd');
        }
        
        if ($formEdit->isSubmitted() && $formEdit->isValid()) {
            $data = $formEdit->getData();
            $product = $em->getRepository(Product::class)->findOneById($data['id']);
            if($data['picture'] != null){
                $file = $data['picture'];
                switch($product->getCategory()->getDescription()){
                    case 'Plantes': $fileName = 'pla_'.$file->getClientOriginalName(); break;
                    case 'Fleurs': $fileName = 'fle_'.$file->getClientOriginalName(); break;
                    case 'Composition': $fileName = 'com_'.$file->getClientOriginalName(); break;
                }
                var_dump($product->getCategory()->getDescription());
                unlink($this->getParameter('photos_directory').'/'. substr($product->getPicture(), 10));
                $file->move($this->getParameter('photos_directory'), $fileName);
                $product->setPicture('/products/'.$fileName);
            }
            $product->setDesignation($data['designation']);
            $product->setPrice($data['price']);
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('gestProd');
        }
        return $this->render('admin/gestProduct.html.twig', ['form' => $form->createView(), 'listProd' => $theProd, 'formEdit' => $formEdit->createView()]);
    }
    
    private function getAllProd(){
        $em = $this->getDoctrine()->getManager();
        $queryProd = $em->createQuery('SELECT p FROM AppBundle:Product p');
        $listProd = $queryProd->execute();
        return $listProd;
    }
    
    /**
     * @Route("/admin/delProd/{id}", name="adminDelProd")
     */
    public function delProdAction($id){
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)->findOneById($id);
        $em->remove($product);
        $em->flush();
        
        return $this->redirectToRoute('gestProd');
    }
    
    /**
     * @Route("/admin/ajoutProd", name="ajoutProd")
     */
    public function ajoutProdAction($id){
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)->findOneById($id);
        $em->remove($product);
        $em->flush();
        
        return $this->redirectToRoute('gestProd');
    }
    
    private function createTheFormEdit($req){
        $form = $this->createFormBuilder()
                ->add('id', HiddenType::class)
                ->add('designation', TextType::class, array('attr'=> array('class' => 'form-control'), 'label' => null))
                ->add('price', NumberType::class, array('attr'=> array('class' => 'form-control'), 'label' => null))
                ->add('category', TextType::class, array('attr'=> array('class' => 'form-control', 'disabled' => true), 'label' => null))
                ->add('picture', FileType::class, array('attr'=> array('class' => 'form-control-file'), 'label' => null, 'required' => false))
                ->add('save', SubmitType::class, array('attr'=> array('class' => 'btn btn-dark float-right'), 'label' => 'Modifier'))
                ->getForm();
        $form->handleRequest($req);
        
        return $form;
    }
}
