<?php

namespace AppBundle\Tests\Controller;

use Doctrine\Bundle\DoctrineBundle\Tests\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends TestCase
{
    public function testBasicExample()
    {
        $data = [10, 20, 30];
        $result = array_sum($data);
        $this->assertEquals(60, $result);
    }
}