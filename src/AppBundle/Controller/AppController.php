<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ob\HighchartsBundle\Highcharts\Highchart;

class AppController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle::layout.html.twig');
    }

    public function addComponentAction()
    {
        
        $mainTitle = "Component creation";

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
            'componentName' => "",
            'mainTitle' => $mainTitle
            ));
    }

    public function editComponentAction()
    {
        
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
