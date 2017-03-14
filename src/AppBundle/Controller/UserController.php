<?php

namespace AppBundle\Controller;

use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\User;
use Knp\Bundle\PaginatorBundle\KnpPaginatorBundle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

class UserController extends Controller
{
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
            $this->get('request')->query->get('pageUsrs', 1), 50,/*limit per page*/
            array(
                'pageParameterName' => 'pageUsrs',
                'sortFieldParameterName' => 'sortUsrs',
                'sortDirectionParameterName' => 'directionUsrs',
            )
        );
        $paginDshs = $this->get('knp_paginator')->paginate($dshs,
            $this->get('request')->query->get('pageDshs', 1), 50,/*limit per page*/
            array(
                'pageParameterName' => 'pageDshs',
                'sortFieldParameterName' => 'sortDshs',
                'sortDirectionParameterName' => 'directionDshs',
            )
        );
        // END PAGINATION //
        // START FORM ADD USER //
        $newUser = new User();
        $form = $this->get('form.factory')->create(new UserType(), $newUser);
        if ($form->handleRequest($request)->isValid()) {
            // $file stores the uploaded image file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $newUser->getImage();
            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            // Move the file to the directory where images are stored
            $file->move(
                $this->getParameter('img_directory'),
                $fileName
            );
            // Update the 'image' property to store the img file name
            // instead of its contents
            $newUser->setImage($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($newUser);
            $em->flush();
            return $this->redirectToRoute('app_admin_profile', array('id' => $id));
        }
        // END FORM ADD USER //
        // START
        // BUILD FORM TO EDIT MY USER INFO //
        
        // START
        // BUILD FORM TO EDIT MY USER INFO //
        $form2 = $this->get('form.factory')->create(new UserType(), $usr);
        // START
        // BUILD FORM TO EDIT ALL USERS INFO //
        // RENDER VARIABLES AND PAGE //
        return $this->render('@App/App/adminProfile.html.twig', array(
            'id' => $id,
            'usr' => $usr,
            'usrs' => $usrs,
            'dsh' => $dsh,
            'dshs' => $dshs,
            'paginUsrs' => $paginUsrs,
            'paginDashs' => $paginDshs,
            'form' => $form->createView(),
//            'form4' => $form4->createView(),
            'form2' => $form2->createView(),
            'newUser' => $newUser
        ));
    }

    public function deleteDashboardAction($usrid, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $usr = $this->container->get('security.context')->getToken()->getUser();
        $usrid = $usr->getId();
        $dashboard = $em->getRepository('AppBundle:Dashboard')->find($id);
        if ($dashboard != null) {
            $em->remove($dashboard);
            $em->flush();
        }
        return $this->redirectToRoute('app_admin_profile', array(
            'id' => $id,
            'dashboard' => $dashboard,
            'usrid' => $usrid
        ));
    }

    // START EDIT OWN USER INFO //
    public function editUserAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $usr = $em->getRepository('AppBundle:User')->find($id);
        $usrs = $em->getRepository('AppBundle:User')->findAll();
        $em->flush();
        // START EDIT USER //
        $form2 = $this->get('form.factory')->create(new UserType(), $usr);
        if ($form2->handleRequest($request)->isValid()) {
            // $file stores the uploaded image file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $usr->getImage();
            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            // Move the file to the directory where images are stored
            $file->move(
                $this->getParameter('img_directory'),
                $fileName
            );
            // Update the 'image' property to store the img file name
            // instead of its contents
            $usr->setImage($fileName);
            $em->merge($usr);
            $em->flush();
            return $this->redirectToRoute('app_admin_profile', array('id' => $id));
        }
        // END FORM EDIT USER //
        return $this->render('@App/App/adminProfile.html.twig', array(
            'id' => $id,
            'usr' => $usr,
            'usrs' => $usrs,
            'form2' => $form2->createView()
        ));
    }
    // END EDIT OWN USER INFO //
    // START EDIT ALL USERS INFO //
    public function editUsersAction(Request $request, $id)
    {
        $superAdmin = $this->container->get('security.context')->getToken()->getUser();
        $superAdminId = $superAdmin->getId();
        $em = $this->getDoctrine()->getManager();
        $usr = $em->getRepository('AppBundle:User')->find($id);
        $usrs = $em->getRepository('AppBundle:User')->findAll();
        $em->flush();
        $form4 = $this->get('form.factory')->create(new UserType(), $usr);
        if ($form4->handleRequest($request)->isValid()) {
            // $file stores the uploaded image file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $usr->getImage();
            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            // Move the file to the directory where images are stored
            $file->move(
                $this->getParameter('img_directory'),
                $fileName
            );
            // Update the 'image' property to store the img file name
            // instead of its contents
            $usr->setImage($fileName);
            $em->merge($usr);
            $em->flush();
            return $this->redirectToRoute('app_admin_profile', array('id' => $superAdminId));
        }
        // END EDIT ALL USERS INFO //
        return $this->render('@App/App/editUser.html.twig', array(
            'id' => $id,
            'usr' => $usr,
            'usrs' => $usrs,
            'superAdmin' => $superAdmin,
            'form4' => $form4->createView()
        ));
    }

    // //
    public function deleteUserAction($id)
    {
        $superAdmin = $this->container->get('security.context')->getToken()->getUser();
        $superAdminId = $superAdmin->getId();
        $em = $this->getDoctrine()->getManager();
        $usr = $em->getRepository('AppBundle:User')->find($id);
        $dashboards = $em->getRepository('AppBundle:Dashboard')->findBy(
            array('creator' => $usr->getId()));
        foreach ($dashboards as $dashboard) {
            $id = $dashboard->getId();
            $components = $em->getRepository('AppBundle:Component')->findBy(
                array('dashboard' => $id));
            foreach ($components as $component) {
                $em->remove($component);
            }
            $em->remove($dashboard);
        }
        $em->remove($usr);
        $em->flush();

        return $this->render('@App/App/deleteUser.html.twig', array(
            'id' => $superAdminId,
            'usr' => $usr
        ));
    }

    public function userProfileAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $usr = $em->getRepository('AppBundle:User')->find($id);
        $usrs = $em->getRepository('AppBundle:User')->findAll();
        $em->flush();
        // START EDIT USER //
        $form3 = $this->get('form.factory')->create(new UserType(), $usr);
        if ($form3->handleRequest($request)->isValid()) {
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $usr->getImage();
            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            // Move the file to the directory where images are stored
            $file->move(
                $this->getParameter('img_directory'),
                $fileName
            );
            // Update the 'image' property to store the img file name
            // instead of its contents
            $usr->setImage($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($usr);
            $em->flush();
            return $this->redirectToRoute('app_user_profile', array('id' => $id));
        }
        // END FORM EDIT USER //
        return $this->render('@App/App/userProfile.html.twig', array(
            'id' => $id,
            'usr' => $usr,
            'usrs' => $usrs,
            'form3' => $form3->createView()
        ));
    }

    /**
     * @Route("/register", name="register")
     */
    public function registerAction()
    {
        return $this->render('@App/Registration/register_content.html.twig');
    }

    /**
     * @Route("/login_check", name="login_check")
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
        $userManager = $this->get('fos_user.user_manager');
    }
}
