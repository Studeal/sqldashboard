<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AppController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle::layout.html.twig');
    }

    public function adminDashMainAction()
    {
        return $this->render('AppBundle:App:adminProfile.html.twig');
    }

    public function paginationAction()
    {
        return $this->container;
    }
}
