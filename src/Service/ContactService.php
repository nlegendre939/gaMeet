<?php

namespace App\Service;

use DateTime;
use App\Entity\Contact;
use App\Service\ContactService;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ContactService 
{
    private $manager;
    private $flash;
    private $mailer;

    public function __construct(EntityManagerInterface $manager, FlashBagInterface $flash)
    {
      $this->manager=$manager;
      $this->flash=$flash;
    }
    public function send(string $subject, string $from, string $to, string $htmlTemplate, array $parameters ): void
    {   
        $message= (new Email())
          ->from($from)
          ->to($to)
          ->subject($subject)
          ->html(
            $this->twig->render($htmlTemplate, $parameters),
            'text/html'
          );
          $this->manager->persist($message);
          $this->manager->flush();
          
          $this->mailer->send($message);
    }
}






    




