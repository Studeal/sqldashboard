<?php

    namespace AppBundle\SQLRequest;

    class SQLRequest
    {
        protected $em;
        private $rqSql;

        /***
        * SQLRequest constructor.
        * @param \Doctrine\ORM\EntityManager $em
        */
        public function __construct(\Doctrine\ORM\EntityManager $em)
        {
            $this->em = $em;
            $this->rqSql = array();
        }

        /***
        * @return array
        */
        public function getRqSql()
        {
            return $this->rqSql;
        }

        /***
        * @param $value
        */
        public function setRqSql($value)
        {
            $this->rqSql = $value;
        }

        /***
        * @param $rqSql
        * @return array
        */
        public function processingSql($rqSql)
        {

            $dataChart = array();
            $xAxis = array();

            //If the request SQL type by user begin by "select"
            $testRequest = explode(" ", $rqSql);

            if(strtoupper($testRequest[0]) == "SELECT")
            {
                //Execute the user's request
                $rq = $this
                    ->em
                    ->getConnection()
                    ->prepare($rqSql);
                $rq->execute([]);

                $datas = $rq->fetchAll();

                //Extract data from db
                foreach($datas as $data)
                {
                    $i = 0;
                    foreach($data as $value)
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
            //If it's not "Select", send empty array
            else
            {
                return array('', '');
            }
        }
    }