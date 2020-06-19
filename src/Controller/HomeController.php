<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ProjetsRepository;
use App\Entity\Projets;

use Doctrine\ORM\EntityManagerInterface; // Connexion a la base de données
use Doctrine\ORM\Mapping as ORM;

class HomeController extends AbstractController
{
	private $projet;
	private $em;

	/**
	*@var ProjetsRepository
	*/
	private $repository;

	public function __construct(ProjetsRepository $repository, EntityManagerInterface $em)
	{
		$this->repository = $repository;
		$this->em = $em;
	}

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
    	$em = $this->getDoctrine()->getManager(); 
    	$projets = $em->getRepository(Projets::class)->findAll();



        return $this->render('home/index.html.twig', [
            'page_name' => 'Accueil',
            'projets' => $projets
        ]);
    }
}
