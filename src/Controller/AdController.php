<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\User;
use App\Form\AdType;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/ad', name: 'ad_')]
class AdController extends AbstractController
{
    private $em;
    private $adRepository;

    public function __construct(
        EntityManagerInterface $em,
        AdRepository $adRepository,
    ){
        $this->em = $em;
        $this->adRepository = $adRepository;
    }

    #[Route('', name: 'list')]
    public function list(Request $request): Response
    {
        $ads = $this->adRepository->findAll();

        return $this->render('ad/list.html.twig', [
            'ads' => $ads,
        ]);
    }

    #[Route('{id}/show', name: 'show', requirements: ['id' => '\d+'])]
    public function show($id): Response
    {
        $ad = $this->adRepository->find($id);

        return $this->render('ad/show.html.twig', [
            'ad' => $ad,
        ]);
    }

    #[Route('/new', name: 'new')]
    // #[Route('/{id}/edit', name: 'edit', requirements: ['id' => '\d+'])]
    // #[IsGranted('AD_FORM', subject: 'ad')]
    public function form(Request $request, /* Ad $ad = null */): Response
    {
        // if($ad){
        //     $isNew = false;
        // }else{
        //     $ad = new Ad();
        //     $ad->setUser($this->getUser());
        //     $isNew = true;
        // }

        $ad = new Ad();
        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) 
        {
            // TODO - Remplacer par l'utilisateur connecté
            $user = $this->em->getRepository(User::class)->find(1);
            $ad->setUser($user);

            $this->em->persist($ad);
            $this->em->flush();

            $this->addFlash('notice', 'Votre annonce à été créé');

            return $this->redirectToRoute('ad_show', [
                'id' => $ad->getId(),
            ]);
        }
        return $this->render('ad/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
