<?php

namespace App\Controller;

use App\Entity\Projets;
use App\Entity\Images;
use App\Repository\ProjetsRepository;
use App\Form\ProjectsType;
use App\Service\FileUploader;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Doctrine\ORM\EntityManagerInterface; // Connexion a la base de données
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PagesController extends AbstractController
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
     * @Route("/projet-{name}", name="project_show")
     * param Projet $projet
     */
    public function show(Projet $projet, string $name)
    {
    	if($projet->getStructureName() !== $name){
    		return $this->redirectToRoute('show', [
    			'name' => $projet->getStructureName()
    		], 301);
    	}


        return $this->render('pages/show.html.twig', [
            'page_name' => 'Projet',
            'projet' => $projet
        ]);
    }


    /**
    *@Route("/projets/nv", name="nv-projet")
    *@param Request $request
    */
    public function newProject(Request $request, SluggerInterface $slugger)
    {
        $errors=[];
        $pj = new Projets();
        $form = $this->createForm(ProjectsType::class, $pj);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
			/** @var UploadedFile $presentationPictFile */
			$presentationPictFile = $form->get('presentation_pict')->getData();

			if ($presentationPictFile){
				$originalFilename = pathinfo($presentationPictFile->getClientOriginalName(), PATHINFO_FILENAME);
				$safeFilename = $slugger->slug($originalFilename);
				$presentationPictFileName = $safeFilename.'-'.uniqid().'-'.$presentationPictFile->guessExtension();
				$presentationPictFile->move(
					$this->getParameter('images_directory'),
					$presentationPictFileName
				);
				$pj->setPresentationPict($presentationPictFileName);
			}
			/*stock l'image en bdd - son nom*/
			$img1 = new Images();
			$img1->setName($presentationPictFileName);
			$pj->addImage($img1);


			/** @var UploadedFile $contextPictFile */
			$contextPictFile = $form->get('context_pict')->getData();

			if ($contextPictFile){
				$originalFilename = pathinfo($contextPictFile->getClientOriginalName(), PATHINFO_FILENAME);
				$safeFilename = $slugger->slug($originalFilename);
				$contextPictFileName = $safeFilename.'-'.uniqid().'-'.$contextPictFile->guessExtension();
				$contextPictFile->move(
					$this->getParameter('images_directory'),
					$contextPictFileName
				);
				$pj->setContextPict($contextPictFileName);
			}
			/*stock l'image en bdd - son nom*/
			$img2 = new Images();
			$img2->setName($contextPictFileName);
			$pj->addImage($img2);

			/** @var UploadedFile $frameworkPictFiles */
			$frameworkPictFile = $form->get('framework_pict')->getData();

			if ($frameworkPictFile){
				$originalFilename = pathinfo($frameworkPictFile->getClientOriginalName(), PATHINFO_FILENAME);
				$safeFilename = $slugger->slug($originalFilename);
				$frameworkPictFileName = $safeFilename.'-'.uniqid().'-'.$frameworkPictFile->guessExtension();
				$frameworkPictFile->move(
					$this->getParameter('images_directory'),
					$frameworkPictFileName
				);
				$pj->setFrameworkPict($frameworkPictFileName);
			}	
			/*stock l'image en bdd - son nom*/
			$img3 = new Images();
			$img3->setName($frameworkPictFileName);
			$pj->addImage($img3);
			
			/** @var UploadedFile $resultPictFiles */
			$resultPictFile = $form->get('result_picture')->getData();

			if ($resultPictFile){
				$originalFilename = pathinfo($resultPictFile->getClientOriginalName(), PATHINFO_FILENAME);
				$safeFilename = $slugger->slug($originalFilename);
				$resultPictFileName = $safeFilename.'-'.uniqid().'.'.$resultPictFile->guessExtension();
				$resultPictFile->move(
					$this->getParameter('images_directory'),
					$resultPictFileName
				);
				$pj->setResultPicture($resultPictFileName);
			}
			/*stock l'image en bdd - son nom*/
			$img4 = new Images();
			$img4->setName($resultPictFileName);
			$pj->addImage($img4);
			




			/*inscription en bdd*/
            $em = $this->getDoctrine()->getManager(); 
            $em->persist($pj);
            $em->flush();
            $this->addFlash('success', 'Projet ajouté avec succès !');

            /*Redirection après ajout en bdd*/
            return $this->redirectToRoute('home');
        }

        return $this->render('pages/new.html.twig', [
           'page_name'  => 'Ajout d\'un nouveau projet',
           'projet'    => $pj,
           'form'       => $form->createView(),
           'error'=> $errors ??[]
        ]);
    }







    /****************Pol de conf *************************/

    /**
     * @Route("/politique-de-confidentialite", name="pol_conf")
     */
    public function pol_conf()
    {
        return $this->render('pages/pol_conf.html.twig', [
            'page_name' => 'Politique de confidentialité',
        ]);
    }


}
