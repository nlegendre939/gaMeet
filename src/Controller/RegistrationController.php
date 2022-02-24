<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Mime\Email;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class RegistrationController extends AbstractController
{



    #[Route('/register', name: 'app_register')]

    public function register(Request $request, EntityManagerInterface $entityManager , MailerInterface  $mailer): Response
    
     {




        $user = new User();

        $form = $this->createForm(RegistrationFormType::class, $user);
        
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
           
          
             
          
            $entityManager = $this->getDoctrine()->getManager();
         $entityManager->persist($user);
         $entityManager->flush();

        $this->addFlash('message', 'Vous avez bien activé votre compte');

        return $this->redirectToRoute('main_index');

     }
        
     return $this->render('registration/register.html.twig',[
         'registrationForm' => $form->createView(),
     ]);

    }

}

          
         
               
                   
                    
   
     
    
