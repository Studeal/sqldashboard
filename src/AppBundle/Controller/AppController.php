<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ob\HighchartsBundle\Highcharts\Highchart;  //Highcharts bundle


class AppController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle::layout.html.twig');
    }


    public function viewAction(){
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

        return $this->render('AppBundle:App:dashboard.html.twig', array(
            'allCharts' => array(
                $ob,
                $ob1,
                $ob2
        )
        ));
    }

public function shareAction()
{
    $user1 = new User();
    $user1->name="Test";
    $user1->checked=1;
    $user2 = new User();
    $user2->name="Test2";
    $user2->checked=1;
    $user3 = new User();
    $user3->name="User";
    $user3->checked=0;
    $user4 = new User();
    $user4->name="Use";
    $user4->checked=1;
    return $this->render('AppBundle:App:shareD.html.twig', array('users' => array($user1,
        $user2,
        $user3,
        $user4)));

}
  
  public function loginAction(){
        return $this->render('AppBundle:App:login.html.twig');
}

    public function adminProfileAction()
    {
        return $this->render('AppBundle:App:adminProfile.html.twig');
    }

    public function userProfileAction()
    {
        return $this->render('AppBundle:App:userProfile.html.twig');
    }
  
    //Method for add a component
    public function addComponentAction()
    {
        //Change the head title
        $mainTitle = "Component creation";

        //Factice charts for display
        $series = array(
        array("name" => "Data Serie Name",    "data" => array(1,2,4,5,6,3,8))
        );

        $ob = new Highchart();
        $ob->chart->renderTo('linechart');
        $ob->title->text('');
        $ob->xAxis->title(array('text'  => "Horizontal axis title"));
        $ob->yAxis->title(array('text'  => "Vertical axis title"));
        $ob->series($series);

        
        return $this->render('AppBundle:App:component.html.twig', array(
            'chart' => $ob,
            'componentName' => "",
            'mainTitle' => $mainTitle
            ));
    }

    //Method for edit a component
    public function editComponentAction($componentId)
    {
        //Change the head title
        $mainTitle = "Component edition";

        //Factice charts
        $series = array(
        array("name" => "Data Serie Name",    "data" => array(1,2,4,5,6,3,8))
        );

        $ob = new Highchart();
        $ob->chart->renderTo('linechart');  // The #id of the div where to render the chart
        $ob->title->text('');
        $ob->xAxis->title(array('text'  => "Horizontal axis title"));
        $ob->yAxis->title(array('text'  => "Vertical axis title"));
        $ob->series($series);


        return $this->render('AppBundle:App:component.html.twig', array(
            'chart' => $ob,
            'componentName' => "Component name1",
            'mainTitle' => $mainTitle
            ));
    }
}
