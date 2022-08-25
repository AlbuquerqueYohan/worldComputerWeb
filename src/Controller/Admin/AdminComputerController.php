<?php

namespace App\Controller\Admin;

use App\Entity\Ordinateurs;
use App\Form\OrdinateurType;
use App\Repository\OrdinateursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Config\TwigConfig;

class AdminComputerController extends AbstractController
{

    /*
     * @var OrdinateursRepository
     */
    public function __construct(OrdinateursRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Route('/admin', name: 'admin_computer_index')]
    public function index()
    {
        $computers = $this->repository->findAll();
        return $this->render('admin/computer/index.html.twig', compact('computers'));
    }

    #[Route('/admin/edit{id}', name: 'admin_computer_edit')]
    public function edit(Ordinateurs $computers)
    {
        $form = $this->createForm(OrdinateurType::class, $computers);
        return $this->render('admin/computer/edit.html.twig',[
            'computers' => $computers,
            'form' => $form->createView()
        ]);
    }
}