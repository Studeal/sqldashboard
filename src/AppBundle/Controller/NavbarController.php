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
    public function NameDashboardAction(Request $request){
//      Get Session_Id
        $user = $this->container->get('security.context')->getToken()->getUser();
        $userId = $user->getId();
        $em=$this
            ->getDoctrine()
            ->getManager();
        $user = $em ->getRepository('AppBundle:User')->find($userId);

        $dashboard = new Dashboard();
        $dashboard->setCreator($user);

//      Building form
        $form = $this->get('form.factory')->create(new DashboardType(), $dashboard);
        $form->handleRequest($request);

//      Push data with doctrine to database
        if($form->isSubmitted() && $form->isValid()){

            $em=$this
                ->getDoctrine()
                ->getManager();

            $em->persist($dashboard);
            $em->flush();

//          Redirect to route of new Dashboard created
            return $this->redirect($this->generateUrl('app_dashboard', array(
                'id'=> $dashboard->getId()
                )
            ));
        }

            $myDashboards=$em->getRepository('AppBundle:Dashboard')
                ->createQueryBuilder('dashboard')
                ->where('dashboard.creator = :creator')
                ->setParameter('creator', $userId )
                ->getQuery()
                ->getResult();

            $sharedDashboards=$em->getRepository('AppBundle:Dashboard')
                ->createQueryBuilder('dashboard')
                ->innerJoin('dashboard.collaborator','user')
                ->where('user.id = :collaboratorId AND dashboard.creator!= :collaboratorId' )
                ->setParameter('collaboratorId', $userId )
                ->getQuery()
                ->getResult();

            return $this->render('AppBundle:App:navbar.html.twig', array(
                'user' => $user,
                'myDashboards'=>$myDashboards,
                'sharedDashboards'=>$sharedDashboards,
                'form' => $form->createView()


          ));
    }

}