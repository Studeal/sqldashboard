<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ob\HighchartsBundle\Highcharts\Highchart;  //Highcharts bundle


class AppController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle::layout.html.twig');
    }

    public function addUserAction(){
        $user = new User();
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
