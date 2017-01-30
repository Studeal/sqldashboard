<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AppController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle::layout.html.twig');
    }
    public function loginAction(){
        return $this->render('AppBundle:App:login.html.twig');
    }
}
