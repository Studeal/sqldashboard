<?php
/**
 * Created by PhpStorm.
 * User: ashleyberthon
 * Date: 15/02/2017
 * Time: 11:12
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\User;
use Knp\Bundle\PaginatorBundle\KnpPaginatorBundle;

class UserController extends Controller
{
    // TODO: Make functions such as show/edit/delete instead of general functions like admin/user!!

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(){
        return $this->render('@App/Security/login_content.html.twig');
    }

    /**
     * @Route("/admin_profile/{id}", name="admin_profile")
     */
    public function adminProfileAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $usr = $em->getRepository('AppBundle:User')->find($id);
        $usrs = $em->getRepository('AppBundle:User')->findAll();
        $dsh = $em->getRepository('AppBundle:Dashboard')->find($id);
        $dshs = $em->getRepository('AppBundle:Dashboard')->findAll();
//        $em->persist($user); // Use when changing info in BDD
        $em->flush();

//        //pagination
//        $paginUsrs = $this->get('knp_paginator')->paginate($listUsers,
//            $this->get('request')->query->get('page', 1), 2/*limit per page*/
//        );
////        return $this->render('AppBundle:App:shareD.html.twig', array(
////            'users' => $users,
////            'dashboard' => $dashboard
////        ));
        
        return $this->render('@App/App/adminProfile.html.twig', array(
            'id'    => $id,
            'usr'   => $usr,
            'usrs'  => $usrs,
            'dsh'   => $dsh,
            'dshs'  => $dshs
        ));
    }

    /**
     * @Route("/user_profile/{id}", name="user_profile")
     */
    public function userProfileAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('user_profile', array('id' => $id));
//        return $this->render('@App/Profile/show_content.html.twig');
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function registerAction()
    {
        return $this->render('@App/Registration/register_content.html.twig');
    }

    /**
     * @Route("/register", name="register")
     */
    public function loginCheckAction()
    {
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
    }

    public function getUser()
    {
//        return parent::getUser();
        $userManager = $this->get('fos_user.user_manager');
    }
}