<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\User;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function contact(Request $request): Response
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

