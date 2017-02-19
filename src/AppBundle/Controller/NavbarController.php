<?php
/**
 * Created by PhpStorm.
 * User: Mazyt
 * Date: 07/02/2017
 * Time: 15:11
 */

namespace AppBundle\Controller;

use AppBundle\Form\DashboardType;
use AppBundle\Entity\Dashboard;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NavbarController extends  Controller
{
    public function NameDashboardAction( Request $request){
        $em=$this->getDoctrine()->getManager();
        $dashboard = new Dashboard();
//        $user = $em
//            ->getRepository('AppBundle: User')
//            ->find($id);
//        $dashboard->setCreator($user);
        $form = $this->createForm(new DashboardType(), $dashboard);


        if($form->handleRequest($request)->isValid()){
            $em->persist($dashboard);
            $em->flush();


            return $this->redirect($this->generateUrl('app_name_dashboard'),
                array('id' =>$dashboard->getId()));

        }

        return $this->render('AppBundle:App:navbar.html.twig', array(

            'form' => $form->createView()));
    }


}