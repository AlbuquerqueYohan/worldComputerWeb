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
            // Utilisation de la méthode findAndWhere avec les différents filtres passés par la vue
            $repository = $this->repository->findAndWhere($request->query->get('filter'));
        } else {
            // Sinon j'utilise la méthode findAll afin de retourner la liste de tous les ordinateurs
            $repository = $this->repository->findAll();
        }
        // Mise en place de la mise en page à l'aide de paginator
        // Ici par défaut la page chargée sera la 1 et je décide d'afficher 8 ordinateurs
        $computers = $paginator->paginate($repository,
            $request->query->get('page', 1),
            8);
        // création de la vue avec les différentes entités que je souhaite envoyer pour générer une vue dynamique
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
        // Je cherche ici un ordinateur en fonction de son ID
        $computer = $this->repository->find($id);
        return $this->render('computer/show.html.twig', [
            'computer' => $computer
        ]);
    }

    #[Route('/compare', name: 'computer_compare')]
    public function compareComputer(Request $request)
    {
        // Je récupere tous les ordinateurs
        $computer = $this->repository->findAll();
        $query = $request->query;
        // Je cherche si le premier ordinateur possède un ID ou sinon je retourne null
        $ordinateur1 = $query->get('id1') ?
            $this->repository->find($query->get('id1')) : null;
        // Je cherche si le second ordinateur possède un ID ou sinon je retourne null
        $ordinateur2 = $query->get('id2') ?
            $this->repository->find($query->get('id2')) : null;
        // Je retourne les différentes entités à ma vue
        return $this->render('computer/compare.html.twig', [
            'ordinateurs' => $computer,
            'ordinateur1' => $ordinateur1,
            'ordinateur2' => $ordinateur2
        ]);
    }
}