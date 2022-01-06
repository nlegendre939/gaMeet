<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HotnewController extends AbstractController
{
    #[Route('/hotnew', name: 'hotnew')]
    public function index(): Response
    {
        return $this->render('hotnew/index.html.twig', [
            'controller_name' => 'HotnewController',
        ]);
    }
}
