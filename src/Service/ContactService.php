<?php

namespace App\Service;

use App\Entity\Contact;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ContactService 
{
    private $manager;
    private $flash;

    public function __construct(EntityManagerInterface $manager,FlashBagInterface $flash)
  {
     $this->manager = $manager;
    $this->flash = $flash;

  }
 public function persistContact(Contact $contact, MailerInterface $mailer): Response

    {   
       

            $this->manager->persist($contact);
            $this->manager->flush();
            $this->flash->add ('envoyé', 'Votre message est bien envoyé, merci.');

    }
            
}






    




