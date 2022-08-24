<?php

namespace App\Controller;

use App\Entity\Ordinateurs;
use App\Repository\OrdinateursRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
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
}