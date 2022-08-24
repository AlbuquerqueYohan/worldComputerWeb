<?php

namespace App\Controller;

use App\Repository\OrdinateursRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
class HomeController extends AbstractController
{
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @return Response
     */
    #[Route('/', name: 'home')]
    public function index(OrdinateursRepository $repository): Response
    {
        $computer = $repository->findLatest();
        return $this->render('pages/home.html.twig', [
            'computer' => $computer
        ]);
    }

}