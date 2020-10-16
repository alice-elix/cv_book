<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\ProjetsRepository;
use App\Entity\Projets;
use App\Entity\Images;

use App\Entity\Mails;
use App\Form\MailType;

use Doctrine\ORM\EntityManagerInterface; // Connexion a la base de données
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\SerializerInterface;

use Swift_Mailer;

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
        $mail = new Mails();
        $form = $this->createForm(MailType::class, $mail);
        
        return $this->render('home/index.html.twig', [
            'page_name' => 'Accueil',
            'form'=>$form->createView(),
            'projets' => $projets,
            
        ]);
    }

    /**
    * @Route("/ajax", name="ajax")
    */

    public function ajaxIndex(Request $request, \Swift_Mailer $mailer, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $mail = new Mails();
        $form = $this->createForm(MailType::class, $mail);
        $erreurs = array();
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()){
                /*envoie du message*/
                $sender = $form->get('name')->getData();
                $emailSender = $form->get('email')->getData();
                $object = $form->get('object')->getData();
                $tel = $form->get('tel')->getData();
                $content = $form->get('content')->getData();
                // $part = $mail->get('part');

                $message = (new \Swift_Message('Hello Email'))
                    ->setFrom('contact@gaelle-david.cmoi.cc')
                    ->setTo('gaelle.david@egaliscope.fr')
                    ->setSubject('Prise de contact par le CV_Book')
                    ->setBody(
                        $this->renderView(
                            'mails/contactPro.html.twig',[
                            // 'origine' => $part,
                            'contacte' => $sender,
                            'email' => $emailSender,
                            'objet' => $object,
                            'num' => $tel,
                            'message' => $content
                            ]),
                        
                        'text/html'
                    )
                ;

                $mailer->send($message);

                /*inscription en bdd*/
                $em = $this->getDoctrine()->getManager(); 
                $em->persist($mail);
                $em->flush();

                /*signale que le message est bien envoyé + inscrit en bdd*/
                $success = true;
            }
            else {
                $liste_erreurs = $validator->validate($mail); // On récupère la liste des erreurs de notre entité $mail
                //Si nous voulons retourné le tableau d'erreurs sous forme JSON, nous sommes tenté d'écrire :
                foreach ($liste_erreurs as $erreur) {                    
                    // On récupère le message d'erreur
                    $erreurs[] = $erreur->getMessage();
                }
            }
            
        }
        return new JsonResponse([
            'success'=> $success ?? false,
            'erreurs'=> $erreurs
        ]);
    }



}
