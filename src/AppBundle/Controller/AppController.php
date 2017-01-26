<?php

namespace AppBundle\Controller;

use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AppController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle::layout.html.twig');
    }

    public function viewAction(){
        $series = array(
            array( "name" => "Data Serie Name",    "data" => array(1,2,4,5,6,3,8))
        );
        $series1 = array(
            array("name" => "Data Serie Name",    "data" => array(1,2,4,5,6,3,8))
        );
        $series2 = array(
            array("type"=>"pie", "name" => "Data Serie Name",    "data" => array(1,2,4,5,6,3,8))
        );

        $ob = new Highchart();
        $ob->chart->renderTo('linechart');  // The #id of the div where to render the chart
        $ob->title->text('');
        $ob->chart->type('bar');
        $ob->xAxis->title(array('text'  => "Horizontal axis title"));
        $ob->yAxis->title(array('text'  => "Vertical axis title"));
        $ob->series($series);

        $ob1 = new Highchart();
        $ob1->chart->renderTo('linechart2');  // The #id of the div where to render the chart
        $ob1->title->text('');
        $ob1->xAxis->title(array('text'  => "Horizontal axis title"));
        $ob1->yAxis->title(array('text'  => "Vertical axis title"));
        $ob1->series($series1);

        $ob2 = new Highchart();
        $ob2->chart->renderTo('linechart3');  // The #id of the div where to render the chart
        $ob2->title->text('');
        $ob2->xAxis->title(array('text'  => "Horizontal axis title"));
        $ob2->yAxis->title(array('text'  => "Vertical axis title"));
        $ob2->series($series2);

        return $this->render('AppBundle:App:dashboard.html.twig', array(
            'chart1' => $ob,
            'chart2' => $ob1,
            'chart3' => $ob2
        ));
    }


}
