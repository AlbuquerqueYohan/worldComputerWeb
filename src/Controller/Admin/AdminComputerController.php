<?php

namespace App\Controller\Admin;

use App\Entity\Marques;
use App\Entity\Ordinateurs;
use App\Form\OrdinateurType;
use App\Repository\OrdinateursRepository;
use Doctrine\Persistence\ObjectManager;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Config\TwigConfig;

class AdminComputerController extends AbstractController
{

    /*
     * @var OrdinateursRepository
     */
    private ObjectManager $em;

    public function __construct(OrdinateursRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    #[Route('/admin', name: 'admin_computer_index')]
    public function index()
    {
        $computers = $this->repository->findAll();
        return $this->render('admin/computer/index.html.twig', compact('computers'));
    }

    /**
     * @param Ordinateurs $computers
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    #[Route('/admin/{id}', name: 'admin_computer_edit')]
    public function edit(Ordinateurs $computers, Request $request)
    {
        $form = $this->createForm(OrdinateurType::class, $computers);
        $marquesRepository = $this->em->getRepository(Marques::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $marque = $marquesRepository->find($request->request->get('marquesFk'));
            $computers->setMarquesFk($marque);
            $filename = $form->get('imageFile')->getData();
            $filename->move(
                'images/computers',
                $filename->getClientOriginalName()
            );
            $computers->setFileName($filename->getClientOriginalName());
            $this->em->flush();
            $this->addFlash('succes', 'Ordinateur modifié avec succès');
            return $this->redirectToRoute('admin_computer_index');
        }

        return $this->render('admin/computer/edit.html.twig',[
            'computers' => $computers,
            'marques' => $marquesRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Ordinateurs $computers
     * @param Request $request
     */
    #[Route('/admin/delete/{id}', name: 'admin_computer_delete', methods: ['DELETE', 'POST'])]
    public function delete(Ordinateurs $computer, Request $request)
    {
        // vérification de la validité du token pour permettre la suppression d'un ordinateur
        if ($this->isCsrfTokenValid('delete', $request->get('_token')))
        {
            // La méthode remove va permettre de créer la requête pour supprimer l'ordinateur passé en paramètre
            $this->em->remove($computer);
            // exécute la requête
            $this->em->flush();
            // Apparition d'un bloc texte en vert permettant de valider à l'utilisateur la suppression de l'ordinateur
            $this->addFlash('succes', 'Ordinateur supprimé du site web');
        }
        return $this->redirectToRoute('admin_computer_index');
    }

    /**
     * @param Request $request
     */
    #[Route('/computer/ajouter', name: 'computer_add', requirements: ['slug' => '[a-z0-9\-]*'])]
    public function add(Request $request)
    {
        // Initialisation d'un nouvel ordinateur
        $computer = new Ordinateurs();
        // Récuperation de toutes les marques
        $marquesRepository = $this->em->getRepository(Marques::class);
        // Création du formulaire avec en paramêtre la nouvelle instance d'ordinateur
        $form = $this->createForm(OrdinateurType::class, $computer);
        // Récuperation du formulaire sous forme de requête
        $form->handleRequest($request);
        // Si le formulaire est envoyé et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // ajout de l'id marque en clé étrangère sur l'ordinateur crée
            $marque = $marquesRepository->find($request->request->get('marquesFk'));
            $computers->setMarquesFk($marque);
            // pesrist permet de sauvegarder les données
            $this->em->persist($computer);
            // exécute la requête
            $this->em->flush();
            // Apparition d'un bloc texte en vert permettant de valider à l'utilisateur l'ajout de l'ordinateur
            $this->addFlash('succes', 'PC ajouté avec succès');
            // retourne ensuite à la vue d'administration des ordinateurs
            return $this->redirectToRoute('admin_computer_index');
        }
        // création de la vue avec les différentes entités que je souhaite envoyer pour générer une vue dynamique
        return $this->render('admin/computer/edit.html.twig', [
            'computer' => $computer,
            'marques' => $marquesRepository->findAll(),
            'form' => $form->createView()
        ]);
    }
}