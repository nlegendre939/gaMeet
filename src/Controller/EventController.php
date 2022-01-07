<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EventController extends AbstractController
{
    #[Route('/event', name: 'event_')]

    public function form(Request $request, Event $event = null): Response
    {

        // Bloc l'acces à la page si l'utilisateur n'est pas identifié


        //dd($this->getUser());


        if($event){
            $isNew = false;
        }else{
            $event = new Event();
            $event->addUser($this->getUser());
            $isNew = true;
        }
        $form = $this->createForm(EventType::class, $event);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // TODO - Remplacer par l'utilisateur connecté
            $user = $this->em->getRepository(User::class)->find(1);
            $ad->setUser($user);

            $this->em->persist($ad);
            $this->em->flush();

            $this->addFlash('notice', 'Votre événement à été créé');

            return $this->redirectToRoute('event_show', [
                'id' => $event->getId(),
            ]);
        }
        
        return $this->render('event/form.html.twig', [
            'form' => $form->createView(),
            'isNew' => $isNew
        ]);
    }

}

