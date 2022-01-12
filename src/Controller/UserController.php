<?php

namespace App\Controller;

use App\Form\SearchUserType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user')]
    public function list(): Response
    {
        $searchForm = $this->createForm(SearchUserType::class);

        return $this->render('user/list.html.twig', [
            'controller_name' => 'UserController',
            'searchForm'=>$searchForm->createView(),
        ]);
    }

 






}
