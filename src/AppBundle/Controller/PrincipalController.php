<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cart;
use AppBundle\Entity\Category;
use AppBundle\Entity\Indent;
use AppBundle\Entity\Product;
use AppBundle\Entity\Row;
use AppBundle\Form\IndentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class PrincipalController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction() {
        return $this->render('client/index.html.twig');
    }
    
    /**
     * @Route("/cat/", name="categories")
     */
    public function catAction() {
        return $this->render('client/categories.html.twig');
    }
    
    /**
     * @Route("/product/{id}", name="products")
     */
    public function prodAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        $hasRow = false;
        if (!$session->has("session")) {
            $session->start();
            $session->set("session", 1);
        }
        
        if (!$session->has("cart")) {
            $cart = new Cart();
        } else {
            $cart = $em->getRepository(Cart::class)->findOneById($session->get("cart"));
        }
        
        $theProd = $this->getAllProdByCat($id);
        if ($request->request->get('idProd') != null) {
            $prod = $em->getRepository(Product::class)->findOneById($request->request->get('idProd'));
            
            foreach ($cart->getRows() as $value) {
                if ($value->getProduct() == $prod) {
                    $hasRow = true;
                }
            }
            
            if ($hasRow) {
                $row = $cart->getRows()->get($cart->getRows()->indexOf($prod));
                $row->setQuantity($row->getQuantity() + $request->request->get('quantity'));
            } else {
                $row = new Row();
                $row->setQuantity($request->request->get('quantity'));
                $row->setProduct($prod);
                $row->setCart($cart);
                $cart->addRow($row);
            }

            $request->request->set('idProd', null);
            $em->persist($row);
            $em->persist($cart);
            $em->flush();
            
            $session->set("cart", $cart->getId());
            
        }

        return $this->render('client/products.html.twig',
            array(      
                'listProd' => $theProd,
            )
        );
    }
    
    /**
     * @Route("/cart", name="cart")
     */
    public function cartAction() {
        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        $total = 0;
        
        if (!$session->has("session")) {
            $session->start();
            $session->set("session", 1);
        }
        
        if ($session->has("cart")) {
            $cart = $em->getRepository(Cart::class)->findOneById($session->get("cart"));
            $theRows = $cart->getRows();
            foreach ($theRows as $row) {
                $total += $row->getProduct()->getPrice() * $row->getQuantity();
            }
        } else {
            $theRows = null;
        }

        return $this->render('client/cart.html.twig',
            array(      
                'listRow' => $theRows,
                'quant' => $total,
            )
        );
    }
    
    private function getAllProdByCat($id){
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Category::class)->findOneById($id);
        $queryProd = $em->createQuery('SELECT p FROM AppBundle:Product p WHERE p.category = :id');
        $queryProd->setParameter('id', $category);
        $listProd = $queryProd->execute();
        return $listProd;
    }
    
    /**
     * @Route("/delProductCart/{id}", name="delProductCart")
     */
    public function delProductCart($id){
        $em = $this->getDoctrine()->getManager();
        $queryDelProd = $em->createQuery('DELETE FROM AppBundle:Row r WHERE r.id = :id');
        $queryDelProd->setParameter('id', $id);
        $queryDelProd->execute();
        
        return $this->redirectToRoute('cart');
    }
    
    /**
     * @Route("/minusProduct/{id}", name="minusProduct")
     */
    public function minusProduct($id){
        $em = $this->getDoctrine()->getManager();
        $row = $em->getRepository(Row::class)->findOneById($id);
        if($row->getQuantity() == 0 || ($row->getQuantity()-1) == 0){
            $this->delProductCart($id);
        } else {
            $row->setQuantity($row->getQuantity()-1);
        }
        
        $em->persist($row);
        $em->flush();
        
        return $this->redirectToRoute('cart');
    }
    
    /**
     * @Route("/plusProduct/{id}", name="plusProduct")
     */
    public function plusProduct($id){
        $em = $this->getDoctrine()->getManager();
        $row = $em->getRepository(Row::class)->findOneById($id);
        $row->setQuantity($row->getQuantity()+1);
        $em->persist($row);
        $em->flush();
        
        return $this->redirectToRoute('cart');
    }
    
    /**
     * @Route("/clearCart", name="clearCart")
     */
    public function clearCart(){
        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        $cart = $em->getRepository(Cart::class)->findOneById($session->get("cart"));
        foreach ($cart->getRows() as $row) {
            $cart->removeRow($row);
            $em->remove($row);
            $em->flush();
        }
        
        $em->remove($cart);
        $em->flush();
        $session->remove("cart");
        return $this->redirectToRoute('cart');
    }
    
    /**
     * @Route("/order", name="order")
     */
    public function orderAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        if (!$session->has("session")) {
            $session->start();
            $session->set("session", 1);
        }
        
        $form = $this->createForm(IndentType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $cart = $em->getRepository(Cart::class)->findOneById($session->get("cart"));
            $data->setCart($cart);
            
            $em->persist($data);
            $em->flush();
            $session->remove("cart");
            return $this->redirectToRoute('homepage');
        }
        return $this->render('client/confirmOrder.html.twig', array('form' => $form->createView()));
    }

}
