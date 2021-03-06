<?php

namespace App\Controller;

use App\Form\ResetPassType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends AbstractController
{
    
    #[Route("/login", name:"login_")]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('main_index');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'error' => $error
        ]);
    }

    #[Route("/logout", name:"logout")]
    public function logout(){
        return $this->render('main/index.html.twig');
    }

    
    #[Route("/oubli-pass", name:"app_forgotten_password")]    
    public function forgottenPass(Request $request, UserRepository $userRepo,EntityManagerInterface $entityManager, MailerInterface  $mailer, TokenGeneratorInterface $tokenGenerator)
    {
        //creation du formulaire
        $form = $this->createForm(ResetPassType::class);

        //on traite le formulaire
        $form->handleRequest($request);

        //si le formulaire est valide
        if($form->isSubmitted() && $form->isValid())
        {
            //ON recupere les données
            $donnees = $form->getData();

            //oncherche si l'utilisateur a cet email
            $user = $userRepo->findOneByEmail($donnees['email']);

            //si l'utilsateur n'existe pas
            if(!$user)
            {
                //on envoi un message flash
                $this->addFlash('danger', 'Erreur lors de l\'envoi');

                $this->redirectToRoute('login');

                //sil existe on genere un token
                $token = $tokenGenerator->generateToken();

                try{
                    $user->setResetToken($token);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persit($user);
                    $entityManager->flush();
                } 
                catch(\Exception $e){
                    $this->addFlash('warning', 'Une erreur est survenue : ' . $e->getMessage());
                    return $this->redirectToRoute('login');
                }
                
                //on genere le lien de reinitialisation
                $url = $this->generateUrl('app_reset_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

                //on envoie le message
                $message = (new Email())
                    ->subject("Recupération de votre mot de passe")
                    //expediteur
                    ->from('gameetu@outlook.fr')
                    //destinataire
                    ->to($user->getEmail())
                    //contenu
                    ->html(
                        $this->renderView(
                            'email/reset-pass.html.twig', ['token'=> $user->getActivationToken()] 
                        ),
                        'text/html'
                    )
                ;

                $mailer->send($message);

                //  on cree le message flash
                $this->addFlash('message', 'Un email de reinitialisation de mdp a ete envoyé');
                return $this->redirectToRoute('login');
            }
            else{
                //On envoie vers la page de demande de l'email
                return $this->render('security/forgotten_password.html.twig', ['emailForm' => $form->createView()]);
            }
        }


        //On envoie vers la page de demande de l'email
        return $this->render('security/forgotten_password.html.twig', ['emailForm' => $form->createView()]);

    }

    
    #[Route("/reset-pass/{token}", name:"app_reset_password")]
    public function resetPassword($token, Request $request, UserPasswordEncoderInterface $passwordEncoder){
        //on cherche l'user avec le token fourni
        $user =$this->getDoctrine()->getRepository(Users::class)->findOneBy(['reset_token' => $token]);
        
        if($user){
            $this->addFlash('danger', 'Token inconnu');
            return $this->redirectToRoute('login');            
        }

        //si le formulaire est envoyé en methodPOST
        if($request->isMethod()){
            //onsuprime le tokn de l'user
            $user->setResetToken(null);

            //on chiffre le mdp
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persit($user);
            $entityManager->flush();

            $this->addFlash('message', 'Mot de passe modifié avec succès');
            return $this->redirectToRoute('login');
        }else{
            return $this->render('security/forgotten_password.html.twig', ['token'=> $token]);
        }
    }
    
    /*
    private function disallowAccess(): Response
    {
        $this->addFlash('info', 'Vous êtes déjà connecté, déconnectez vous pour changer de compte');
        return $this->redirectToRoute('main_index');
    }
    */
    
}
