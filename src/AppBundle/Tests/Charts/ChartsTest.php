<?php

namespace AppBundle\Tests\Charts;

use AppBundle\Charts\Charts;

class ChartsTest extends \PHPUnit_Framework_TestCase
{
    public function testRequestSql()
    {
        $req = new Charts();
        $result = $req->requestSql(1);
    }
}

