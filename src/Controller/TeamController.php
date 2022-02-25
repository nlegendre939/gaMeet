<?php

namespace App\Controller;
use App\Entity\Team;
use App\Form\SearchUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TeamController extends AbstractController
{
    #[Route('/team', name: 'team')]
    public function index(Request $request): Response
    {
        {
            $user = new Team();
            $searchForm = $this->createForm (SearchUserType ::class);
    
            $searchForm->handleRequest($request);

            if ($searchForm->isSubmitted() && $searchForm->isValid()) 
            {
                $this->addFlash('notice','Votre recherche à bien été éffectué');
    
                return $this->redirectToRoute('team', [
                    'id' => $user->getId(),
                ]);
            }
                
            return $this->render('team/index.html.twig', [
                'searchForm'  => $searchForm->createView(),
            ]);
        }
    }
    
    
    }



