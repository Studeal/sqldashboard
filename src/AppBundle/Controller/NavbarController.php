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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NavbarController extends  Controller
{
    public function NameDashboardAction(Request $request){

        $dashboard = new Dashboard();
        $form = $this->createForm(new DashboardType(), $dashboard);


        if($form->handleRequest($request)->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($dashboard);
            $em->flush();


            return $this->redirect($this->generateUrl('app_namedash'), array('id' =>$dashboard->getId()));

        }

        return $this->render('AppBundle:App:navbar.html.twig', array(

            'form' => $form->createView()));
    }


}