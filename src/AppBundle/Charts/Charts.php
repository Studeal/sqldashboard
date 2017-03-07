<?php
namespace AppBundle\Charts;
use Ob\HighchartsBundle\Highcharts\Highchart;
use AppBundle\SQLRequest\SQLRequest;
class Charts
{
    private $xAxis;
    private $yAxis;
    private $legend;
    private $requestSql;
    private $typeGraph;
    protected $sqlRq;
    /***
     * Charts constructor.
     * @param SQLRequest $sqlRq
     */
    public function __construct(SQLRequest $sqlRq)
    {
        $this->xAxis      = "X axis name";
        $this->yAxis      = "Y axis name";
        $this->legend     = "Legend name";
        $this->requestSql = array('');
        $this->typeGraph  = "column";
        $this->sqlRq      = $sqlRq;
    }
    /***
     * @param $value
     */
    public function setXAxis($value){
        $this->xAxis = $value;
    }
    /***
     * @param $value
     */
    public function setYAxis($value){
        $this->yAxis = $value;
    }
    /***
     * @param $value
     */
    public function setLegend($value){
        $this->legend = $value;
    }
    /***
     * @param $value
     */
    public function setRequestSql($value){
        $this->requestSql = $value;
    }
    /***
     * @param $value
     */
    public function setTypeGraph($value){
        $this->typeGraph = $value;
    }
    /***
     * @return string
     */
    public function getXAxis(){
        return $this->xAxis;
    }
    /***
     * @return string
     */
    public function getYAxis(){
        return $this->yAxis;
    }
    /***
     * @return string
     */
    public function getLegend(){
        return $this->legend;
    }
    /***
     * @return array
     */
    public function getRequestSql(){
        return $this->requestSql;
    }
    /***
     * @return string
     */
    public function getTypeGraph(){
        return $this->typeGraph;
    }
    /***
     * @param $key
     * @return Highchart
     */
    public function generateChart($key){
        //Get data from user's request
        $this->requestSql = $this->sqlRq->processingSql($this->requestSql);
        //Set data for chart with db's data
        $series = array(array(
            "name" => $this->legend,
            "data" => $this->requestSql[0]
        ));
        //Create new chart
        $chart = new Highchart();
        $chart->chart->renderTo("chart".$key);
        //Line chart does not need type
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