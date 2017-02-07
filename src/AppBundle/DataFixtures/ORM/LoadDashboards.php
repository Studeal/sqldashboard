<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Dashboards;

class LoadDashboards implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $names = array(
            'Dashboard 1',
            'Dashboard 2',
            'Dashboard 3',
            'Dashboard 4'
        );

        foreach ($names as $name){
            $dashboard = new Dashboards();
            $dashboard->setNameDash($name);
            $dashboard->setIdUsersCreator(1);

            $manager->persist($dashboard);
        }

        $manager->flush();
    }
    
}
