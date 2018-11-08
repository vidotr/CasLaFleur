<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cart;
use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use AppBundle\Entity\Row;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class PrincipalController extends Controller {

    /**
     * @Route("/")
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
    public function cartAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        
        if (!$session->has("session")) {
            $session->start();
            $session->set("session", 1);
        }
        
        if ($session->has("cart")) {
            $cart = $em->getRepository(Cart::class)->findOneById($session->get("cart"));
        }
        
        $theRows = $cart->getRows();
        $total = 0;
        foreach ($theRows as $row) {
            $total += $row->getProduct()->getPrice() * $row->getQuantity();
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
}
