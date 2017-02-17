<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ComponentControllerTest extends WebTestCase
{
    public function testAddComponent()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/component/1/add');
        
        $this->assertEquals('AppBundle\Controller\ComponentController::addComponentAction', $client->getRequest()->attributes->get('_controller'));
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
    }
}