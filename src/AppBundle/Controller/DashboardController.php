<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ob\HighchartsBundle\Highcharts\Highchart;  //Highcharts bundle


class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle::layout.html.twig');
    }


    public function viewAction(){
//
        $series = array(
            array("name" => "Data Serie Name",    "data" => array(1,2,4,5,6,3,8))
        );
        $series1 = array(
            array("name" => "Data Serie Name",    "data" => array(1,6,4,22,3,5,8,8,11))
        );
        $series2 = array(
            array("name" => "Data Serie Name",    "data" => array(19,2,4,5,6,22,8))
        );

        $ob = new Highchart();
        $ob->chart->renderTo('linechart0');  // The #id of the div where to render the chart
        $ob->title->text('');
        $ob->chart->type('');
        $ob->xAxis->title(array('text'  => "Horizontal axis title"));
        $ob->yAxis->title(array('text'  => "Vertical axis title"));
        $ob->series($series);

        $ob1 = new Highchart();
        $ob1->chart->renderTo('linechart1');  // The #id of the div where to render the chart
        $ob1->title->text('');
        $ob1->xAxis->title(array('text'  => "Horizontal axis title"));
        $ob1->yAxis->title(array('text'  => "Vertical axis title"));
        $ob1->series($series1);

        $ob2 = new Highchart();
        $ob2->chart->renderTo('linechart2');  // The #id of the div where to render the chart
        $ob2->title->text('');
        $ob2->xAxis->title(array('text'  => "Horizontal axis title"));
        $ob2->yAxis->title(array('text'  => "Vertical axis title"));
        $ob2->series($series2);

        $dashboards = $this->getDoctrine()->getRepository('AppBundle:Dashboards')->findAll();
        dump($dashboards);

        return $this->render('AppBundle:App:dashboard.html.twig', array(
            'allCharts' => array(
                $ob,
                $ob1,
                $ob2
            ),
            'dashboards'=>$dashboards
        ));
    }



    public function shareAction($id)
    {
$em = $this->getDoctrine()->getManager();
$dashboards = $em
    ->getRepository('AppBundle:Dashboards')
    ->find($id);


        $em = $this->getDoctrine()->getManager();
$users =$em
    ->getRepository('AppBundle:User')
    ->findAll();

        $listUsers = $em
            ->getRepository('AppBundle:User')


//        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
//        dump($users);


        return $this->render('AppBundle:App:shareD.html.twig', array(

            'users'=>$listUsers,
        'dashboard'=>$dashboards
        ));
    }


}
