<?php

namespace App\Controller;

use App\Entity\Marques;
use App\Entity\Ordinateurs;
use App\Entity\OrdinateursSearch;
use App\Form\OrdinateursSearchType;
use App\Form\OrdinateurType;
use App\Repository\OrdinateursRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\PaginatorInterface;
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
    public function showAll(PaginatorInterface $paginator, Request $request): Response
    {
        $repository = [];
        $marquesRepository = $this->em->getRepository(Marques::class);
        if ($request->query->get('filter')) {
            $repository = $this->repository->findWhereText($request->query->get('filter'));
        }else {
            $repository = $this->repository->findAll();
        }
        $computer = $paginator->paginate($repository,
            $request->query->get('page', 1),
            8);
        return $this->render('computer/index.html.twig', [
            'marques' => $marquesRepository->findAll(),
            'type_stockages' => Ordinateurs::TYPE_STOCKAGE,
            'type_ordinateurs' => Ordinateurs::TYPE,
            'ordinateur' => $computer,
            'filters' => $request->query->get('filter')
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
}