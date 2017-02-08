<?php
/**
 * Created by PhpStorm.
 * User: Mazyt
 * Date: 07/02/2017
 * Time: 15:11
 */

namespace AppBundle\Controller;

use AppBundle\Form\DashboardsType;
use AppBundle\Entity\Dashboards;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NavbarController extends  Controller
{
    public function NameDashboardAction(Request $request){
        $dashboard = new Dashboards();
//      $form = $this->get('form.factory')->create(new DashboardsType, $dashboard);
        $form = $this->createForm(new DashboardsType(), $dashboard);

        if($form->handleRequest($request)->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($dashboard);
            $em->flush();

//            $request->getSession()->getFlashBag()->add('notice', 'Dashboard created');

            return $this->redirect($this->generateUrl('app_home'), array('id' =>$dashboard->getId()));

        }

        return $this->render('AppBundle:App:navbar.html.twig', array('form' => $form->createView()));
    }
}