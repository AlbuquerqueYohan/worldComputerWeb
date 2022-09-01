<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecuityController extends AbstractController
{

    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    #[Route('/login', name: 'login')]
        public function login(AuthenticationUtils $authenticationUtils)
        {
            // get the login error if there is one
            $error = $authenticationUtils->getLastAuthenticationError();
            // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();
            return $this->render('security/login.html.twig', [
                'last_username' => $lastUsername,
                'error'         => $error,
            ]);
        }


    #[Route('/ajouterUtilisateur', name: 'user_add')]
    public function addUser(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($user->algoCryptage($user->getPassword()));
            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('succes', 'Administrateur ajouté avec succès');
            return $this->redirectToRoute('home');
        }

        return $this->render('security/adduser.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
}