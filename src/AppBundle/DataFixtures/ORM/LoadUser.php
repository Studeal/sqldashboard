<?php
namespace AppBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadUser implements FixtureInterface
{
    public function load(ObjectManager $manager){
        $users = array(
            array('firstName' => 'Jean',
                'lastName' => 'Fernandez',
                'userName'=> 'jean_F',
                'email' => 'jeanF@gmail.com',
                'password'=> 'pass',
                'image'=> 'img',
                'status'=> false,
            ),
            array('firstName' => 'Marc',
                'lastName' => 'Charles',
                'userName'=> 'marc_F',
                'email' => 'marcC@gmail.com',
                'password'=> 'pass',
                'image'=> 'img1',
                'status'=> false,)
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
            $manager->persist($utilisateur);
        }

        $manager->flush();
    }
}