<?php

namespace App\Controller;

use App\Entity\Ordinateurs;
use App\Form\OrdinateurType;
use App\Repository\OrdinateursRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ComputerController extends AbstractController
{

    private $repository;
    private $em;

    public function __construct(OrdinateursRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @return Response
     */
    #[Route('/computer', name: 'computer_index')]
    public function index(): Response
    {
        return $this->render('computer/index.html.twig');
    }

    #[Route('/computer', name: 'computer_index')]
    public function showAll()
    {
        $computer = $this->repository->findAll();
        return $this->render('computer/index.html.twig', [
                'ordinateur' => $computer
            ]);
    }

    #[Route('/computer/{slug}-{id}', name: 'computer_show', requirements: ['slug' => '[a-z0-9\-]*'])]
    public function show($slug, $id)
    {
        $computer = $this->repository->find($id);
        return $this->render('computer/show.html.twig', [
            'ordinateur' => $computer
        ]);
    }

    #[Route('/computer/ajouter', name: 'computer_add', requirements: ['slug' => '[a-z0-9\-]*'])]
    public function add(Request $request)
    {
        $computer = new Ordinateurs();
        $form = $this->createForm(OrdinateurType::class, $computer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->em->persist($computer);
            $this->em->flush();
            $this->addFlash('succes', 'PC ajouté avec succès');
            return $this->redirectToRoute('home');
        }

        return $this->render('admin/computer/edit.html.twig',[
            'computer' => $computer,
            'form' => $form->createView()
        ]);
    }
}