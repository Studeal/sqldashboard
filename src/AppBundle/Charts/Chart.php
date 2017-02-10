<?php

namespace AppBundle\Charts;

use Ob\HighchartsBundle\Highcharts\Highchart;

class Charts
{
    protected $em;

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function requestSql($idComp)
    {
        $repository = $this
            ->em
            ->getRepository('AppBundle:Components');

        $result = $repository->find($idComp);

        $rq = $this->getEntityManager()->getConnection()->prepare($result->getRequestSQL());
        $rq->execute([]);

        return $rq->fetchAll();
    }

    private function processingSql($idComp)
    {
        
        $sql = explode(" ", requestSql($idComp));

        $xAxis = $sql[1];
        $yAxis = $sql[2];

        return array($xAxis, $yAxis);
    }

    public function charts($idComp)
    {
        //Find the good component
        $repository = $this
            ->em
            ->getRepository('AppBundle:Components');

        $component = $repository->find($idComp);

        $axisName = processingSql($idComp);
        $requestSql = requestSql($idComp);

        $series = array(
            array("name" => $component->getLabel(), "data" => $requestSql)
        );

        $chart = new Highchart();
        $chart->chart->renderTo($component->getTypeGraph());
        $chart->title->text('');
        $chart->xAxis->title(array('text'  => $axisName[0]));
		$chart->yAxis->title(array('text'  => $axisName[1]));
		$chart->series($series);


        return $chart;
        // if($component['typeGraph '] == "piechart" )
        // {
        //     $ob->plotOptions->pie(array(
        //         'allowPointSelect' => true,
        //         'dataLabels'       => array(
        //             'enabled' => true,
        //             'format'  => '<b>{point.name}</b>: {point.percentage:.1f} %'),
                
        //     ))
        // }
    }

}