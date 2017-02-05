<?php

namespace AppBundle\Controller;


use Doctrine\DBAL\Query\QueryBuilder;
use Knp\Bundle\PaginatorBundle\KnpPaginatorBundle;
use AppBundle\Entity\Dashboards;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ob\HighchartsBundle\Highcharts\Highchart;  //Highcharts bundle
use Symfony\Component\HttpFoundation\Request;


class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle::layout.html.twig');
    }


    public function viewAction($id)
    {
//
        $series = array(
            array("name" => "Data Serie Name", "data" => array(1, 2, 4, 5, 6, 3, 8))
        );
        $series1 = array(
            array("name" => "Data Serie Name", "data" => array(1, 6, 4, 22, 3, 5, 8, 8, 11))
        );
        $series2 = array(
            array("name" => "Data Serie Name", "data" => array(19, 2, 4, 5, 6, 22, 8)),
            array("name" => "Data Serie Name2", "data" => array(19, 2, 4, 5, 6, 22, 8))
        );

        $ob = new Highchart();
        $ob->chart->renderTo('linechart0');  // The #id of the div where to render the chart
        $ob->title->text('');
        $ob->chart->type('');
        $ob->xAxis->title(array('text' => "Horizontal axis title"));
        $ob->yAxis->title(array('text' => "Vertical axis title"));
        $ob->series($series);

        $ob1 = new Highchart();
        $ob1->chart->renderTo('linechart1');  // The #id of the div where to render the chart
        $ob1->title->text('');
        $ob1->xAxis->title(array('text' => "Horizontal axis title"));
        $ob1->yAxis->title(array('text' => "Vertical axis title"));
        $ob1->series($series1);

        $ob2 = new Highchart();
        $ob2->chart->renderTo('linechart2');  // The #id of the div where to render the chart
        $ob2->title->text('');
        $ob2->xAxis->title(array('text' => "Horizontal axis title"));
        $ob2->yAxis->title(array('text' => "Vertical axis title"));
        $ob2->series($series2);

        $dashboards = $this->getDoctrine()->getRepository('AppBundle:Dashboards')->find($id);
        dump($dashboards);

        return $this->render('AppBundle:App:dashboard.html.twig', array(
            'allCharts' => array(
                $ob,
                $ob1,
                $ob2
            ),
            'dashboards' => $dashboards
        ));
    }


    public function shareAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $dashboards = $em
            ->getRepository('AppBundle:Dashboards')
            ->find($id);

//        $findUsers = $em->getRepository('AppBundle:User')->byCategorie($username);
//        $listUsers = $em
//            ->getRepository('AppBundle:User')
//            ->findAll();


        $parameter = $request->get('search');
        $listUsers = $em
            ->getRepository('AppBundle:User')->createQueryBuilder('u')
            ->where('u.username LIKE :usern')
            ->setParameter('usern', '%'.$parameter.'%')
            ->getQuery()
            ->getResult();






//        if form has been submited removes all users from dashboard, adds the checked ones and saves them in the database

        if ($request->get('activeUsers')) {
            $activeUsers = $request->get('activeUsers');

            foreach ($listUsers as $inactiveUser) {
                $inactiveUser->removeDashboard($dashboards);
                $em->persist($inactiveUser);
            }

            foreach ($activeUsers as $active) {
                $user = $em->getRepository('AppBundle:User')
                    ->find($active);
                $user->addDashboard($dashboards);
                $em->persist($user);

            }
            $em->flush();
            return $this->redirectToRoute('app_home');
        }
        $users  = $this->get('knp_paginator')->paginate($listUsers,
            $this->get('request')->query->get('page',1), 1/*limit per page*/
        );

        return $this->render('AppBundle:App:shareD.html.twig', array(

            'users' => $users,
            'dashboard' => $dashboards
        ));
    }




    //.......Delete dashboard
    public function deleteDashAction($id){
        $em = $this->getDoctrine()->getManager();
        $dashboard = $em->getRepository('AppBundle:Dashboards')->find($id);

        if ($dashboard != null){
            $em->remove($dashboard);
            $em->flush();
        }
        $em->flush();
        return $this->redirectToRoute('app_home');
    }

}
