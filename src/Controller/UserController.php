<?php

namespace App\Controller;

use App\Form\SearchUserType;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user')]
    public function list(Request $request): Response
    {
        $user = new User();
        $searchForm = $this->createForm (SearchUserType ::class);

        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted() && $searchForm->isValid()) 
        {
            $this->addFlash('notice','Votre recherche à bien été éffectué');

            return $this->redirectToRoute('user', [
                'id' => $user->getId(),
            ]);
        }
            
        return $this->render('user/list.html.twig', [
            'searchForm'  => $searchForm->createView(),
        ]);
    }
}


