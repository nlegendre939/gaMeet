<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use App\Controller\ContactController;
use App\Entity\UserPasswordHasherInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Form\UserPasswordHasherInterfaceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\UserPasswordHasherInterfaceController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ContactController extends AbstractController 
{
    #[Route('/contact', name:'contact_')]

    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $contact = new Contact();

        $form=$this->createForm(ContactType::class);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $contact = $form->getData();
            
            $message = (new TemplatedEmail())
                ->from($contact['email'])
                ->to('gameetu@outlook.fr')
                ->subject('Prise de contact')
                ->htmlTemplate('email/contact.html.twig')
                ->context([
                    'mail'=>$contact['email'],
                    'message'=>$contact['message']
                ]);

            $mailer->send($message);

            $this->addFlash('message', 'Votre message bien été envoyé');

            return $this->redirectToRoute('main_index');
        }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            
        ]);
    }    
        
}            