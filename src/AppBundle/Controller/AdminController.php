<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Indent;
use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        $theProd = $this->getAllProd();
        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $cat = $em->getRepository(Category::class)->findOneById(1);
            $data->setCategory($cat);
            $em->persist($data);
            $em->flush();
        }
        return $this->render('admin/gestProduct.html.twig', ['form' => $form->createView(), 'listProd' => $theProd]);
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
}
