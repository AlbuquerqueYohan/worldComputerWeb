<?php

namespace App\Controller\Admin;

use App\Repository\OrdinateursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
        $allComputer = $this->repository->findAll();
        return $this->render('admin/computer/index.html.twig');
    }

}