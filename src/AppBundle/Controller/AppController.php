<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AppController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle::layout.html.twig');
    }

    public function adminDashAction()
    {
        return $this->render('AppBundle:App:adminProfile.html.twig');
    }
}
