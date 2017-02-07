<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Dashboards;
use AppBundle\Form\DashboardsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ob\HighchartsBundle\Highcharts\Highchart;

Class DashboardController extends Controller
{

    public function NamedashAction () {
        $dashboards = new Dashboards;
        $form = $this->get('form.factory')->create(new DashboardsType, $dashboards);

        if ($form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($dashboards);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Dashboard are created !');

            return $this->redirect($this->generateUrl('AppBundle:App:navbar.html.twig', array('id' => $dashboards->getId())));


        }
        return $this->render('AppBundle:App:navbar.html.twig', array('form' => $form->createView(),));
    }
}