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
    public function delete(Ordinateurs $computers, Request $request)
    {
        if ($this->isCsrfTokenValid('delete', $request->get('_token')))
        {
            $this->em->remove($computers);
            $this->em->flush();
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
        $computer = new Ordinateurs();
        $marquesRepository = $this->em->getRepository(Marques::class);
        $form = $this->createForm(OrdinateurType::class, $computer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $marque = $marquesRepository->find($request->request->get('marquesFk'));
            $computers->setMarquesFk($marque);
            $this->em->persist($computer);
            $this->em->flush();
            $this->addFlash('succes', 'PC ajouté avec succès');
            return $this->redirectToRoute('admin_computer_index');
        }

        return $this->render('admin/computer/edit.html.twig', [
            'computer' => $computer,
            'marques' => $marquesRepository->findAll(),
            'form' => $form->createView()
        ]);
    }
}