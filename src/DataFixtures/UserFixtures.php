<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Users;
use Faker;
use Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class UserFixtures extends Fixture
{ 
    const DATA = [
        [
            'firstname' => "John",
            'lastname' => "DOE",
            'username' => "Geekeur7",
            'email' => "geekeur7@game.com",
            'password' => "123456",
            'roles' => ["ROLE_USER"],
        ],
        [
            'firstname' => "John",
            'lastname' => "DOE",
            'username' => "Pikachu59",
            'email' => "pikachu@bep.com",
            'password' => "123456",
            'roles' => ["ROLE_USER"],
        ],
        [
            'firstname' => "John",
            'lastname' => "DOE",
            'username' => "Badass",
            'email' => "badass@gmail.com",
            'password' => "123456",
            'roles' => ["ROLE_USER"],
        ],
        [
            'firstname' => "John",
            'lastname' => "DOE",
            'username' => "darklight",
            'email' => "darklight@light.com",
            'password' => "123456",
            'roles' => ["ROLE_USER"],
        ],
        [
            'firstname' => "John",
            'lastname' => "DOE",
            'username' => "Queen",
            'email' => "queen@outlook.com",
            'password' => "123456",
            'roles' => ["ROLE_USER"],
        ],
        [
            'firstname' => "John",
            'lastname' => "DOE",
            'username' => "CobraX",
            'email' => "cobra@snake.com",
            'password' => "123456",
            'roles' => ["ROLE_USER"],
        ],
        [
            'firstname' => "John",
            'lastname' => "DOE",
            'username' => "ninjaboy",
            'email' => "ninjaboy@gun.com",
            'password' => "123456",
            'roles' => ["ROLE_USER"],
        ],
    ];

    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder =$encoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
       
       
        
                for($nbUsers = 1; $nbUsers <10 ; $nbUsers++);
            $user = new User();
            $user->setEmail($faker->email);
            if($nbUsers ===1)
               $user->setRoles(['ROLE_ADMIN']);
            else 
                 $user->setRoles(['ROLE_USER']);

          $user->setPassword($this->encoder->encodePassword($user,
          'azerty'));
          $user->setLastname($faker->lastName);
          $user->setFirstName($faker->firstName);
          $user->setBirthdate( new \DateTime() );
          
          $user->setIsVerified($faker->numberBetween());
          
          
             $manager->persist($user);

             $manager->flush();
    }
}