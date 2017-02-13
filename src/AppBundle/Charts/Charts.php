<?php

namespace AppBundle\Charts;

use Ob\HighchartsBundle\Highcharts\Highchart;
use AppBundle\RequestSql\RequestSql; 

class Charts
{
    private $xAxis;
    private $yAxis;
    private $legend;
    private $requestSql;
    private $typeGraph;
    protected $rqSql;

    public function __construct(RequestSql $rqSql)
    {
        $this->xAxis      = "X axis name";
        $this->yAxis      = "Y axis name";
        $this->legend     = "Legend name";
        $this->requestSql = array('');
        $this->typeGraph  = "column";
        $this->rqSql      = $rqSql;
    }

    public function setXAxis($value){
        $this->xAxis = $value;
    }

    public function setYAxis($value){
        $this->yAxis = $value;
    }

    public function setLegend($value){
        $this->legend = $value;
    }

    public function setRequestSql($value){
        $this->requestSql = $value;
    }

    public function setTypeGraph($value){
        $this->typeGraph = $value;
    }

    public function getXAxis(){
        return $this->xAxis;
    }

    public function getYAxis(){
        return $this->yAxis;
    }

    public function getLegend(){
        return $this->legend;
    }

    public function getRequestSql(){
        return $this->requestSql;
    }

    public function getTypeGraph(){
        return $this->typeGraph;
    }

    public function generateChart($key){

        $this->requestSql = $this->rqSql->processingSql($this->requestSql);

        $series = array(array(
                        "name" => $this->legend, 
                        "data" => $this->requestSql[0] 
                        ));

        $chart = new Highchart();
        $chart->chart->renderTo("chart".$key);
        if($this->typeGraph != "linechart"){
            $chart->chart->type($this->typeGraph);
        }
        $chart->title->text('');
        $chart->xAxis->title(array('text'  => $this->xAxis));
        $chart->xAxis->categories($this->requestSql[1]);
		$chart->yAxis->title(array('text'  => $this->yAxis));
		$chart->series($series);

        return $chart;
    }
}