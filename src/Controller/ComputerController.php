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

    #[Route('/computer', name: 'computer_index')]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        // Initialisation d'un tableau repository qui sera vide au départ
        $repository = [];
        // Récupération des marques pour les filtres
        $marquesRepository = $this->em->getRepository(Marques::class);
        // Si $request contient une key 'filter'
        if ($request->query->get('filter'))
        {
            // Utilisation de la méthode findAndWhere avec les différents filtre passé par la vue
            $repository = $this->repository->findAndWhere($request->query->get('filter'));
        } else {
            // Sinon j'utilise la méthode findAll afin de retourner la liste de tous les ordinateurs
            $repository = $this->repository->findAll();
        }
        // Mise en place de la mise en page à l'aide de paginator
        // Ici par défaut la page chargé sera la 1 et je descide d'afficher 8 ordinateurs
        $computers = $paginator->paginate($repository,
            $request->query->get('page', 1),
            8);
        return $this->render('computer/index.html.twig', [
            'marques' => $marquesRepository->findAll(),
            'type_stockages' => Ordinateurs::TYPE_STOCKAGE,
            'type_computer' => Ordinateurs::TYPE,
            'computers' => $computers,
            'filters' => $request->query->get('filter')
        ]);

    }

    #[Route('/computer/{slug}-{id}', name: 'computer_show', requirements: ['slug' => '[a-z0-9\-]*'])]
    public function show($slug, $id)
    {
        $computer = $this->repository->find($id);
        return $this->render('computer/show.html.twig', [
            'ordinateurs' => $computer
        ]);
    }

    #[Route('/compare', name: 'computer_compare')]
    public function compareComputer(Request $request)
    {
        $computer = $this->repository->findAll();
        $query = $request->query;

        $ordinateur1 = $query->get('id1') ?
            $this->repository->find($query->get('id1')) : null;

        $ordinateur2 = $query->get('id2') ?
            $this->repository->find($query->get('id2')) : null;

        return $this->render('computer/compare.html.twig', [
            'ordinateurs' => $computer,
            'ordinateur1' => $ordinateur1,
            'ordinateur2' => $ordinateur2
        ]);
    }
}