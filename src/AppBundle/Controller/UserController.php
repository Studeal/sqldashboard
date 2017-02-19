<?php
/**
 * Created by PhpStorm.
 * User: Mazyt
 * Date: 15/02/2017
 * Time: 13:44
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function loginAction(){
        return $this->render('AppBundle:Security:login.html.twig');
    }

    public function adminProfileAction()
    {
        return $this->render('AppBundle:App:adminProfile.html.twig');
    }

    public function userProfileAction()
    {
        return $this->render('AppBundle:App:userProfile.html.twig');
    }
}



