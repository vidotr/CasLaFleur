<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
}
