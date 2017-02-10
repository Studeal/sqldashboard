<?php

namespace AppBundle\DataFixtures\ORM;
use AppBundle\Entity\Dashboards;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadUser implements FixtureInterface
{
    public function load(ObjectManager $manager){
        $dashboard = new Dashboards();
        $dashboard->setNameDash('nameDash');
        $dashboard->setIdUsersCreator(4);
        $users = array(
            array('firstName' => 'Jean',
                  'lastName' => 'Fernandez',
                  'userName'=> 'jean_F3',
                  'email' => 'jeanF3@gmail.com',
                  'password'=> 'pass',
                'image'=> 'img',
                'status'=>'active',
                ),
            array('firstName' => 'Jeans',
                'lastName' => 'Fernandes',
                'userName'=> 'jean_F2',
                'email' => 'jeanF12@gmail.com',
                'password'=> 'pass',
                'image'=> 'img',
                'status'=>'active',
            ),
             array('firstName' => 'Marc',
                 'lastName' => 'Charles',
                 'userName'=> 'marc_F3',
                 'email' => 'marc3C@gmail.com',
                 'password'=> 'pass',
                 'image'=> 'img1',
                 'status'=>'active',)
        );

        foreach ($users as $user){
                $utilisateur = new User();
                $utilisateur->setFirstName($user['firstName']);
                $utilisateur->setLastName($user['lastName']);
                $utilisateur->setEmail($user['email']);
                $utilisateur->setUsername($user['userName']);
                $utilisateur->setPassword($user['password']);
                $utilisateur->setImage($user['image']);
                $utilisateur->setStatus($user['status']);
                $utilisateur->addDashboard($dashboard);
                $manager->persist($utilisateur);
            }

        $manager->flush();
    }
}
