<?php
/**
 * Created by PhpStorm.
 * User: Us
 * Date: 2/1/2017
 * Time: 7:08 PM
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\DataFixtures\ORM\LoadUser;
use AppBundle\Entity\Dashboards;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class LoadDashboard implements FixtureInterface
{
public function load(ObjectManager $manager){

    $dashboards = array(
        array('nameDash' => 'first_dash',
            'idUsersCreator' => 1

        ),
        array('nameDash' => 'second_dash',
            'idUsersCreator' => 2

        )
        );
    foreach ($dashboards as $dash){
        $dashboard = new Dashboards();
        $dashboard->setNameDash($dash['nameDash']);
        $dashboard->setIdUsersCreator($dash['idUsersCreator']);

        $manager->persist($dashboard);
    }

    $manager->flush();
}
}