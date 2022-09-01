<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecuityController extends AbstractController
{

    private $em;
    private $repository;

    public function __construct(ObjectManager $em, UserRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    #[Route('/administrateur', name: 'user_index')]
    public function index()
    {
        $user = $this->repository->findAll();
        return $this->render('security/index.html.twig', compact('user'));
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
            'error' => $error,
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
            return $this->redirectToRoute('user_index');
        }

        return $this->render('security/adduser.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    #[Route('/administrateur/{id}', name: 'user_edit')]
    public function edit(User $user, Request $request)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($user->algoCryptage($user->getPassword()));
            $this->em->flush();
            $this->addFlash('succes', 'Administrateur modifié avec succès');
            return $this->redirectToRoute('user_index');
        }

        return $this->render('security/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    #[Route('/administrateur/delete/{id}', name: 'user_delete', methods: ['DELETE', 'POST'])]
    public function delete(User $user, Request $request)
    {
        if ($this->isCsrfTokenValid('delete', $request->get('_token'))) {
            $this->em->remove($user);
            $this->em->flush();
            $this->addFlash('succes', 'Administrateur supprimé de la base');
        }
        return $this->redirectToRoute('user_index');
    }
}