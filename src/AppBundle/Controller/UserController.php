<?php
/**
 * Created by PhpStorm.
 * User: ashleyberthon
 * Date: 15/02/2017
 * Time: 11:12
 */

namespace AppBundle\Controller;

use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\User;
use Knp\Bundle\PaginatorBundle\KnpPaginatorBundle;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function loginAction(){
        return $this->render('@App/Security/login_content.html.twig');
    }

    public function adminProfileAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $usr = $em->getRepository('AppBundle:User')->find($id);
        $usrs = $em->getRepository('AppBundle:User')->findAll();
        $dsh = $em->getRepository('AppBundle:Dashboard')->find($id);
        $dshs = $em->getRepository('AppBundle:Dashboard')->findAll();
        $em->flush();

        // START PAGINATION //
        $paginUsrs = $this->get('knp_paginator')->paginate($usrs,
            $this->get('request')->query->get('page', 1), 3/*limit per page*/
        );

        $paginDshs = $this->get('knp_paginator')->paginate($dshs,
            $this->get('request')->query->get('page', 1), 3/*limit per page*/
        );
        // END PAGINATION //

        // START FORM ADD USER //
        $newUser = new User();

        $form = $this->get('form.factory')->create(new UserType(), $newUser);

        if($form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($newUser);
            $em->flush();

            return $this->redirectToRoute('app_admin_profile', array('id' => $id));
        }
        // END FORM ADD USER //

        return $this->render('@App/App/adminProfile.html.twig', array(
            'id'            => $id,
            'usr'           => $usr,
            'usrs'          => $usrs,
            'dsh'           => $dsh,
            'dshs'          => $dshs,
            'paginUsrs'     => $paginUsrs,
            'paginDashs'    => $paginDshs,
            'form'          => $form->createView()
        ));
    }

    public function editUserAction()
    {
        return $this->container;
    }

    public function deleteUserAction()
    {
        return $this->container;
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