<?php

namespace App\Controller;

use App\Entity\Projets;
use App\Entity\Images;
use App\Entity\Mails;
use App\Repository\ProjetsRepository;
use App\Form\ProjectsType;
use App\Form\MailType;
use App\Service\FileUploader;

use Swift_Mailer;

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
     * @Route("/projet-{id}", name="project_show")
     * @param Request $request
     * @param Projets $projet
     */
    public function show(string $id, Request $request, \Swift_Mailer $mailer)
    {
    	/*affichage des pages*/
    	$em = $this->getDoctrine()->getManager(); 
    	$projet = $em->getRepository(Projets::class)->find($id);
    	$part = $projet->getStructureName();
    	$photos = $em->getRepository(Images::class)->findAll(['id'=>$projet]);
    	$presentationPict = $em->getRepository(Images::class)->findByField('presentation_pict', $id);	
    	// $contextPict = $em->getRepository(Images::class)->findByField('context_pict', $id);
    	$frameworkPict = $em->getRepository(Images::class)->findByField('framework_pict', $id);
    	$resultPict = $em->getRepository(Images::class)->findByField('result_picture', $id);

    	/*formulaire de contact*/
    	$errors=[];
    	$mail = new Mails();
    	$form = $this->createForm(MailType::class, $mail);        

        return $this->render('pages/show.html.twig', [
            'page_name' => 'Projet',
            'projet' => $projet,
            'photos' => $photos,
            'presentation'=> $presentationPict ?? [],
            'context'=> $contextPict ?? [],
            'framework'=> $frameworkPict ?? [],
            'result'=> $resultPict ?? [],
            'form'=>$form->createView(),
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
			$presentationPictField = $form->get('presentation_pict')->getName();

			if (isset($presentationPictFile)){
				$originalFilename = pathinfo($presentationPictFile->getClientOriginalName(), PATHINFO_FILENAME);
				$safeFilename = $slugger->slug($originalFilename);
				$presentationPictFileName = $safeFilename.'-'.uniqid().'.'.$presentationPictFile->guessExtension();
				$presentationPictFile->move(
					$this->getParameter('images_directory'),
					$presentationPictFileName
				);
                $pj->setPresentationPict($presentationPictFileName);    			
    			/*stock l'image en bdd - son nom*/
    			$img1 = new Images();
    			$img1->setName($presentationPictFileName);
    			$img1->setField($presentationPictField);
    			$pj->addImage($img1);
            }

			/** @var UploadedFile $contextPictFile */
			// $contextPictFile = $form->get('context_pict')->getData();
			// $contextPictField = $form->get('context_pict')->getName();

			// if (isset($contextPictFile)){
   //  			$originalFilename = pathinfo($contextPictFile->getClientOriginalName(), PATHINFO_FILENAME);
   //  			$safeFilename = $slugger->slug($originalFilename);
   //  			$contextPictFileName = $safeFilename.'-'.uniqid().'.'.$contextPictFile->guessExtension();
   //  			$contextPictFile->move(
   //  				$this->getParameter('images_directory'),
   //  				$contextPictFileName
   //  			);
   //  			$pj->setContextPict($contextPictFileName);
   //  			/*stock l'image en bdd - son nom*/
   //  			$img2 = new Images();
   //  			$img2->setName($contextPictFileName);
   //  			$img2->setField($contextPictField);
   //  			$pj->addImage($img2);
			// }

			/** @var UploadedFile $frameworkPictFiles */
			$frameworkPictFiles = $form->get('framework_pict')->getData();
			$frameworkPictField = $form->get('framework_pict')->getName();

			if (isset($frameworkPictFiles)){
    			foreach ($frameworkPictFiles as $frameworkPictFile){
					$originalFilename = pathinfo($frameworkPictFile->getClientOriginalName(), PATHINFO_FILENAME);
					$safeFilename = $slugger->slug($originalFilename);
					$frameworkPictFileName = $safeFilename.'-'.uniqid().'.'.$frameworkPictFile->guessExtension();
					$frameworkPictFile->move(
				 		$this->getParameter('images_directory'),
				 		$frameworkPictFileName
				 	);
    				/*stock l'image en bdd - son nom*/
    				$img3 = new Images();
    				$img3->setName($frameworkPictFileName);
    				$img3->setField($frameworkPictField);
    				$pj->addImage($img3);
    			}
			}	
			
			/** @var UploadedFile $resultPictFiles */
			$resultPictFiles = $form->get('result_picture')->getData();
			$resultPictField = $form->get('result_picture')->getName();

			if (isset($resultPictFiles)){
    			foreach ($resultPictFiles as $resultPictFile){
					$originalFilename = pathinfo($resultPictFile->getClientOriginalName(), PATHINFO_FILENAME);
					$safeFilename = $slugger->slug($originalFilename);
					$resultPictFileName = $safeFilename.'-'.uniqid().'.'.$resultPictFile->guessExtension();
					$resultPictFile->move(
						$this->getParameter('images_directory'),
						$resultPictFileName
					);
    				/*stock l'image en bdd - son nom*/
    				$img4 = new Images();
    				$img4->setName($resultPictFileName);
    				$img4->setField($resultPictField);
    				$pj->addImage($img4);
    				
    			}
			}
				

			/*inscription en bdd*/
            $em = $this->getDoctrine()->getManager(); 
            $em->persist($pj);
            $em->flush();
            $this->addFlash('success', 'Projet ajouté avec succès !');
            
            
        }

        return $this->render('pages/new.html.twig', [
           'page_name'  => 'Ajout d\'un nouveau projet',
           'projet'    => $pj,
           'form'       => $form->createView(),
           'error'=> $errors ??[]
        ]);
    }


    /**
    *@Route("/projets/edit/{id}", name="edit-projet", methods="GET|POST")
    *@param Projets $pj
    *@param Request $request
    */
    public function edit(string $id, Projets $pj, Request $request, SluggerInterface $slugger)
    {
        $pathPict = 'uploads/pictures/';

        $form = $this->createForm(ProjectsType::class, $pj);
        $form->handleRequest($request);

        
        $em = $this->getDoctrine()->getManager(); 

        $oldPresentationPict = $em->getRepository(Images::class)->findByField('presentation_pict', $id);
        if(!empty($oldPresentationPict)){
            $oldPresentationPictPath = $pathPict.$oldPresentationPict[0]->getName();
        }   

        // $oldContextPict = $em->getRepository(Images::class)->findByField('context_pict', $id);

        $oldFrameworkPicts = $em->getRepository(Images::class)->findByField('framework_pict', $id);

        $oldResultPicts = $em->getRepository(Images::class)->findByField('result_picture', $id);
        
        dump($oldPresentationPict);
        dump($oldFrameworkPicts);
        dump($oldResultPicts);
        // if(!empty($oldPresentationPict)){
        //     dump($pathPict.$oldPresentationPict[0]->getName());
        // }

        if($form->isSubmitted() && $form->isValid()){

            /** @var UploadedFile $presentationPictFile */
            $presentationPictFile = $form->get('presentation_pict')->getData();
            $presentationPictField = $form->get('presentation_pict')->getName();

            if (isset($presentationPictFile)){
                /*suppression des anciennes photos*/
                if($oldPresentationPict != null){
                    unlink($oldPresentationPictPath);
                    $this->em->remove($oldPresentationPict[0]);
                    $this->em->flush();
                }

                $originalFilename = pathinfo($presentationPictFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $presentationPictFileName = $safeFilename.'-'.uniqid().'.'.$presentationPictFile->guessExtension();
                $presentationPictFile->move(
                    $this->getParameter('images_directory'),
                    $presentationPictFileName
                );
                $pj->setPresentationPict($presentationPictFileName);
                /*stock l'image en bdd - son nom*/
                $img1 = new Images();
                $img1->setName($presentationPictFileName);
                $img1->setField($presentationPictField);
                $pj->addImage($img1);
            }

            /** @var UploadedFile $contextPictFile */
            // $contextPictFile = $form->get('context_pict')->getData();
            // $contextPictField = $form->get('context_pict')->getName();

            // if (isset($contextPictFile)){
            //     $originalFilename = pathinfo($contextPictFile->getClientOriginalName(), PATHINFO_FILENAME);
            //     $safeFilename = $slugger->slug($originalFilename);
            //     $contextPictFileName = $safeFilename.'-'.uniqid().'.'.$contextPictFile->guessExtension();
            //     $contextPictFile->move(
            //         $this->getParameter('images_directory'),
            //         $contextPictFileName
            //     );
            //     $pj->setContextPict($contextPictFileName);
            //     /*stock l'image en bdd - son nom*/
            //     $img2 = new Images();
            //     $img2->setName($contextPictFileName);
            //     $img2->setField($contextPictField);
            //     $pj->addImage($img2);
            // }

            /** @var UploadedFile $frameworkPictFiles */
            $frameworkPictFiles = $form->get('framework_pict')->getData();
            $frameworkPictField = $form->get('framework_pict')->getName();

            if (!empty($frameworkPictFiles)){
                /*suppression des anciennes photos*/
                if($oldFrameworkPicts != null){
                    foreach ($oldFrameworkPicts as $oldFrameworkPict) {
                        $oldFrameworkPictPath = $pathPict.$oldFrameworkPict->getName();
                        unlink($oldFrameworkPictPath);
                        $this->em->remove($oldFrameworkPict);
                        $this->em->flush();
                    }
                }

                foreach ($frameworkPictFiles as $frameworkPictFile){
                    $originalFilename = pathinfo($frameworkPictFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $frameworkPictFileName = $safeFilename.'-'.uniqid().'.'.$frameworkPictFile->guessExtension();
                    $frameworkPictFile->move(
                        $this->getParameter('images_directory'),
                        $frameworkPictFileName
                    );
                    /*stock l'image en bdd - son nom*/
                    $img3 = new Images();
                    $img3->setName($frameworkPictFileName);
                    $img3->setField($frameworkPictField);
                    $pj->addImage($img3);
                }
            }   
            
            /** @var UploadedFile $resultPictFiles */
            $resultPictFiles = $form->get('result_picture')->getData();
            $resultPictField = $form->get('result_picture')->getName();

            if (!empty($resultPictFiles)){
                /*suppression des anciennes photos*/
                if(($oldResultPicts)!= null){
                    foreach ($oldResultPicts as $oldResultPict) {
                        $oldResultPictPath = $pathPict.$oldResultPict->getName();
                        unlink($oldResultPictPath);
                        $this->em->remove($oldResultPict);
                        $this->em->flush();
                    }
                }

                foreach ($resultPictFiles as $resultPictFile){
                    $originalFilename = pathinfo($resultPictFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $resultPictFileName = $safeFilename.'-'.uniqid().'.'.$resultPictFile->guessExtension();
                    $resultPictFile->move(
                        $this->getParameter('images_directory'),
                        $resultPictFileName
                    );
                    /*stock l'image en bdd - son nom*/
                    $img4 = new Images();
                    $img4->setName($resultPictFileName);
                    $img4->setField($resultPictField);
                    $pj->addImage($img4);
                    
                }
            }


            $this->em->flush();
            $this->addFlash('success', 'Projet modifié avec succès !');
            
        }



        return $this->render('pages/edit.html.twig', [
                   'page_name'  => 'Edition d\'un projet',
                   'projet'    => $pj,
                   'form'       => $form->createView(),
                   'error'=> $errors ??[]
        ]);
    }


    /**
    *@Route("/projets/edit/{id}", name="del-projet", methods="DELETE")
    *@param Projets $pj
    *@param Request $request
    */
    public function delete(Projets $pj, Request $request){
        if($this->isCsrfTokenValid('delete'.$pj->getId(), $request->get('_token'))){
        $this->em->remove($pj);
        $this->em->flush();
        $this->addFlash('success', 'Projet supprimé avec succès !');

        }
        return $this->redirectToRoute('home');

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
