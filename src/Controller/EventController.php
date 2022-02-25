<?php

namespace App\Controller;

use app\Entity\User;
use App\Entity\Event;
use App\Form\EventType;
use App\Form\SearchEventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('event', name: 'event_')]
class EventController extends AbstractController
{
    private $em;
    private $eventRepository;

    public function __construct(
        EntityManagerInterface $em,
        EventRepository $eventRepository,
    ){
        $this->em = $em;
        $this->eventRepository = $eventRepository;
    }
    #[Route('', name: 'list')]
    public function list(Request $request): Response
    {
        $searchForm = $this->createForm(SearchEventType::class);
        $searchForm->handleRequest($request);
        $searchCriteria = $searchForm->getData();

        $events = $this->eventRepository->search($searchCriteria);

        return $this->render('event/list.html.twig', [
            'events' => $events,
            'searchForm' => $searchForm->createView(),
        ]);
    }

    #[Route('{id}/show', name: 'show', requirements: ['id' => '\d+'])]
    public function show($id): Response
    {
        $event = $this->eventRepository->find($id);

        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/new',name: 'new')]
    public function form(Request $request, Event $event =null): Response
    {
        if($event){
            $isNew = false;
        }else{
            $event = new Event();
            $event->addUser($this->getUser());
            $isNew = true;
        }
        
        // $event = new Event();
        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            // TODO - Remplacer par l'utilisateur connecté
            // $user = $this->em->getRepository(User::class)->find(1);
            // $event->addUser($user);

            $this->em->persist($event);
            $this->em->flush();

            $this->addFlash('notice', 'Votre événement à été créé');

            return $this->redirectToRoute('event_show', [
                'id' => $event->getId(),
            ]);
        }
        return $this->render('event/form.html.twig', [
            'form' => $form->createView()
        ]);

    
        
    }
      
       #[Route("/event/{id}/delete",name:"event_delete")]
       public function delete(Event $event): Response

       {
            $em = $this->getDoctrine()->getManager();
            $em ->remove($event);
            $em->flush();

            $this->addFlash('notice', 'Votre événement à été suprimée');

            return $this->redirectToRoute(route:"event_show");
                
            
       }

       

    
}