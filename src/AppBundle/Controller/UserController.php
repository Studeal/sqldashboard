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
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

        // $file stores the uploaded image file
        /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
        $file = $usr->getImage();

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

        if($form->handleRequest($request)->isValid()) {

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->getExtension();

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

        // START EDIT USER //
        $form2 = $this->get('form.factory')->create(new UserType(), $usr);

        if($form2->handleRequest($request)->isValid()) {

            // Generate a unique name for the file before saving it

            $fileName = md5(uniqid()).'.'.$file->getExtension();
            
            // Move the file to the directory where images are stored
            $file->move(
                $this->getParameter('img_directory'),
                $fileName
            );

            // Update the 'image' property to store the img file name
            // instead of its contents
            $usr->setImage($fileName);
            $usr->setFirstName('tataouine');

            $em = $this->getDoctrine()->getManager();

            $em->persist($usr);
            $em->flush();

            return $this->redirectToRoute('app_admin_profile', array('id' => $id));
        }
        // END FORM EDIT USER //

        return $this->render('@App/App/adminProfile.html.twig', array(
            'id'            => $id,
            'usr'           => $usr,
            'usrs'          => $usrs,
            'dsh'           => $dsh,
            'dshs'          => $dshs,
            'paginUsrs'     => $paginUsrs,
            'paginDashs'    => $paginDshs,
            'form'          => $form->createView(),
            'form2'         => $form2->createView()
        ));
    }

    public function deleteDashAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $dashboard = $em->getRepository('AppBundle:Dashboard')->find($id);
        if ($dashboard != null) {
            $em->remove($dashboard);
            $em->flush();
        }
        return $this->redirectToRoute('app_dashboard', array('id' => $id));//to do redirect to homepage
    }

    public function editUserAction()
    {
        return $this->container;
    }

    public function deleteUserAction()
    {
        return $this->container;
    }


    public function userProfileAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $usr = $em->getRepository('AppBundle:User')->find($id);
        $usrs = $em->getRepository('AppBundle:User')->findAll();
        $em->flush();

        /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
        $file = $usr->getImage();

        // START EDIT USER //
        $form3 = $this->get('form.factory')->create(new UserType(), $usr);

        if($form3->handleRequest($request)->isValid()) {

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->getExtension();

            // Move the file to the directory where brochures are stored
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
        // END FORM ADD USER //

        return $this->render('@App/App/userProfile.html.twig', array(
            'id'            => $id,
            'usr'           => $usr,
            'usrs'          => $usrs,
            'form3'         => $form3->createView()
        ));
//        return $this->render('@App/App/userProfile.html.twig');
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
//        return parent::getUser();
        $userManager = $this->get('fos_user.user_manager');
    }
}