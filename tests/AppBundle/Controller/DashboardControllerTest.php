<?php
/**
 * Created by PhpStorm.
 * User: Us
 * Date: 2/8/2017
 * Time: 10:16 AM
 */


namespace AppBundle\Controller;
use AppBundle\Entity\Dashboards;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\DoctrineBundle\Tests\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class DashboardControllerTest extends WebTestCase
{


//    public function testView()
//    {
//       $dashboard = $this->getMock(Dashboards::class);
//       $dashboard->expects($this->once())
//          ->method('getNameDash')
//          ->will($this->returnValue('newdash'));
//
//        $this->assertEquals('newdash', $dashboard->getNameDash());
//    }


public function testDashboardAction(){
    $client =static::createClient();
    $crawler = $client->request('GET', '/11');
    $this->assertTrue($crawler->filter('html:contains("This")')->count()>0);
}

    public function testAttribute()
    {
        $this->assertClassHasAttribute('nameDash', Dashboards::class);
    }



}
