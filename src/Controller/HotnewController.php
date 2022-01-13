<?php

namespace App\Controller;

use App\Entity\Hotnew;
use App\Entity\User;
use App\Form\HotnewType;
use App\Repository\HotnewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/hotnew', name: 'hotnew_')]
class HotnewController extends AbstractController
{
    private $em;
    private $hotnewRepository;

    public function __construct(
        EntityManagerInterface $em,
        HotnewRepository $hotnewRepository,
    ){
        $this->em = $em;
        $this->hotnewRepository = $hotnewRepository;
    }

    #[Route('', name: 'list')]
    public function list(Request $request): Response
    {
        $hotnews = $this->hotnewRepository->findAll();

        return $this->render('hotnew/list.html.twig', [
            'hotnews' => $hotnews,
        ]);
    }

    #[Route('{id}/show', name: 'show', requirements: ['id' => '\d+'])]
    public function show($id): Response
    {
        $hotnew = $this->hotnewRepository->find($id);

        return $this->render('hotnew/show.html.twig', [
            'hotnew' => $hotnew,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function form(Request $request, Ad $hotnew = null): Response
    {
        if($hotnew){
            $isNew = false;
        }else{
            $hotnew = new Hotnew();
            $hotnew->setUser($this->getUser());
            $isNew = true;
        }

        // $hotnew = new Hotnew();
        $form = $this->createForm(HotnewType::class, $hotnew);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) 
        {
            // TODO - Remplacer par l'utilisateur connecté
            // $user = $this->em->getRepository(User::class)->find(1);
            // $hotnew->setUser($user);

            $this->em->persist($hotnew);
            $this->em->flush();

            $this->addFlash('notice', 'Votre actualité à été créé');

            return $this->redirectToRoute('hotnew_show', [
                'id' => $hotnew->getId(),
            ]);
        }
        return $this->render('hotnew/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
