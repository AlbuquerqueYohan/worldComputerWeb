<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
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
        // Récupération de l'erreur de login si il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();
        // dernier username saisie par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }


    #[Route('/ajouterUtilisateur', name: 'user_add')]
    public function addUser(Request $request)
    {
        // Initialisation d'une instance User
        $user = new User();
        // Création du formulaire
        $form = $this->createForm(UserType::class, $user);
        // Récuperation du formulaire sous forme de requête
        $form->handleRequest($request);
        // Si le formulaire est envoyé et valide
        if ($form->isSubmitted() && $form->isValid()) {
        // Récupération du mot de passe saisie et utilisation de algoCryptage pour crypter le mot de passe
            $user->setPassword($user->algoCryptage($user->getPassword()));
            // pesrist permet de sauvegarder les données
            $this->em->persist($user);
            // exécute la requête
            $this->em->flush();
            // Apparition d'un bloc texte en vert permettant de valider à l'utilisateur l'ajout d'un administrateur
            $this->addFlash('succes', 'Administrateur ajouté avec succès');
            // retourne ensuite à la vue d'administration des ordinateurs
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