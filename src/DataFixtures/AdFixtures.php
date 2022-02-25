<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Images;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


use Faker;
use Factory;




class AdFixtures extends Fixture implements DependentFixtureInterface
{ 

    
  
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
       
       
        
                for($nbAd = 1; $nbAd <30 ; $nbAd++);
            $user = $this->getReference('user_'. $faker->numberBetween(1,30));  
            $categorie = $this->getReference(('categorie_'.
            $faker->numberBetween(1,4)));
           
            $ad = new Ad();
            $ad->setUsers($user);
            $ad->setCategories($categorie);
            $ad->setTitle($faker->realText(25));
            $ad->setContent($faker->realText(400));
            $ad->setActive($faker->numberBetween(0, 1));

            //on uploade et on génère les images
          
            for($picture = 1; $picture < 4; $image++){
                $picture = $faker->picture('public\images\ad');
                $picturesAd = new Images();
                $pictureAd->setName(str_replace('public\images\ad', '', $picture));
                $ad->getPicture($pictureAd);
            }
          
             $manager->persist($ad);

             $manager->flush();
    }
  
    public function getDependencies()
    {
        return [
            UserFixtures::class,
           
        ];
    }
   
      }

    