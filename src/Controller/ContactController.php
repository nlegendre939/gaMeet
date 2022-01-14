<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\ContactService;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, ContactService $contactService, MailerInterface $mailer): Response
    {
        $contact = new Contact();
        $form = $this -> createForm (ContactType ::class, $contact);
        $form->handleRequest($request);
        
        

        

      if ($form->isSubmitted() && $form->isValid()) {
         $this->addFlash('notice','Votre email à bien été envoyée');
        
         
        
         return $this->redirectToRoute('contact', [
            'id' => $contact->getId(),
        ]);
    }
         
     return $this->render('contact/index.html.twig', [
        'form' => $form->createView()
    ]);


}
}

