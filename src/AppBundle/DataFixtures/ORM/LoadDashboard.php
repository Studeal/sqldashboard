<?php
/**
 * Created by PhpStorm.
 * User: Us
 * Date: 2/1/2017
 * Time: 7:08 PM
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\DataFixtures\ORM\LoadUser;
use AppBundle\Entity\Dashboard;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class LoadDashboard implements FixtureInterface
{
public function load(ObjectManager $manager){

    $dashboard = array(
        array('name' => 'first_dash',
            'idCreator' => 1

        ),
        array('name' => 'second_dash',
            'idCreator' => 2
        )
        );

    foreach ($dashboard as $dash){
        $dashboard = new Dashboard();
        $dashboard->setName($dash['name']);

        $manager->persist($dashboard);
    }

    $manager->flush();
}
}