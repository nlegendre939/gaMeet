<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{ 

    const DATA = [
        [
            'firstname' => "John",
            'lastname' => "DOE",
            'nickname' => "Geekeur7",
            'email' => "geekeur7@game.com",
            'password' => "123456",
            'roles' => ["ROLE_USER"],
        ],
        [
            'firstname' => "John",
            'lastname' => "DOE",
            'nickname' => "Pikachu59",
            'email' => "pikachu@bep.com",
            'password' => "123456",
            'roles' => ["ROLE_USER"],
        ],
        [
            'firstname' => "John",
            'lastname' => "DOE",
            'nickname' => "Badass",
            'email' => "badass@gmail.com",
            'password' => "123456",
            'roles' => ["ROLE_USER"],
        ],
        [
            'firstname' => "John",
            'lastname' => "DOE",
            'nickname' => "darklight",
            'email' => "darklight@light.com",
            'password' => "123456",
            'roles' => ["ROLE_USER"],
        ],
        [
            'firstname' => "John",
            'lastname' => "DOE",
            'nickname' => "Queen",
            'email' => "queen@outlook.com",
            'password' => "123456",
            'roles' => ["ROLE_USER"],
        ],
        [
            'firstname' => "John",
            'lastname' => "DOE",
            'nickname' => "CobraX",
            'email' => "cobra@snake.com",
            'password' => "123456",
            'roles' => ["ROLE_USER"],
        ],
        [
            'firstname' => "John",
            'lastname' => "DOE",
            'nickname' => "ninjaboy",
            'email' => "ninjaboy@gun.com",
            'password' => "123456",
            'roles' => ["ROLE_USER"],
        ],
    ];

    /**
     * Password encode interface
     * 
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as $item)
        {
            $user = new User;

            $hashed = $this->encoder->encodePassword($user, $item['password']);

            $user->setNickname( $item['nickname'] );
            $user->setFirstname( $item['firstname'] );
            $user->setLastname( $item['lastname'] );
            $user->setEmail( $item['email'] );
            $user->setPassword( $hashed );
            $user->setRoles( $item['roles'] );
            $user->setBirthdate( new \DateTime() );


            $manager->persist($user);
        }
        for($i=0; $i<=5; $i++)
        {
            $hotnew = new Hotnew();

            $hotnew->setTitle('hotnew');
            $hotnew->setSlug();
            $hotnew->setContent();
            $hotnew->setCreateAt();
            $hotnew->setPublishAt();
            $hotnew->setEditAt();
            $hotnew->setPicture();
            
        }
            $manager->flush();
    }


    // getOrders () {
        //return 1;
    //}
}
