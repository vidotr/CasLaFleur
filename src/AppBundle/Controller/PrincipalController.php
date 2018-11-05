<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        $theProd = $this->getAllProdByCat($id);
        var_dump($request->request->get('idProd'));
        return $this->render('client/products.html.twig',
            array(      
                'listProd' => $theProd,
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
