<?php

namespace AppBundle\RequestSql;

class RequestSql

{

    protected $em;

    private $rqSql;

    public function __construct(\Doctrine\ORM\EntityManager $em)

    {

        $this->em = $em;

        $this->rqSql = array();

    }

    public function getRqSql()

    {

        return $this->rqSql;

    }

    public function setRqSql($value)

    {

        $this->rqSql = $value;

    }

    public function processingSql($rqSql)

    {

        $dataChart = array();

        $xAxis = array();

        $testRequest = explode(" ", $rqSql);

        if($testRequest[0] == "SELECT")

        {

            $rq = $this

                ->em

                ->getConnection()

                ->prepare($rqSql);

            $rq->execute([]);

            $datas = $rq->fetchAll();

            foreach($datas as $data)

            {

                $i = 0;

                foreach($data as $key => $value)

                {

                    if($i == 0)

                    {

                        array_push($xAxis, $value);

                        $i = 1;

                    }

                    else{

                        array_push($dataChart, (float)$value);

                        $i = 0;

                    }

                }

            }

            return array($dataChart, $xAxis);

        }

        else

        {

            return array('', '');

        }

    }

}