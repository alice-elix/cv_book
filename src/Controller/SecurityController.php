<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


use App\Form\InscriptionType;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class SecurityController extends AbstractController
{
    /**
	* @var UserPasswordEncoderInterface
	*/
	private $encoder;

	public function __construct(UserPasswordEncoderInterface $encoder)
	{
		$this->encoder = $encoder;
	}
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
    	$error = $authenticationUtils->getLastAuthenticationError();
    	$lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig',[
        	'last_username' => $lastUsername,
        	'error' => $error,
            'page_name' => 'la page de connexion'
        ]);
    }

    /**
     * @Route("/inscription", name="inscription")
     *@param Request $request
     */
    public function inscription(Request $request)
    {
    	$user = new User();
    	$form = $this->createForm(InscriptionType::class, $user);
    	$form->handleRequest($request);

    	if($form->isSubmitted() && $form->isValid()){

    		$em = $this->getDoctrine()->getManager(); 
    	    $password = $_POST["inscription"]["password"];

    		$user->setPassword($this->encoder->encodePassword($user, $password ));
    	    $em->persist($user);
    	    $em->flush();
    	    $this->addFlash('success', 'Inscription validée ! Il est temps de se connecter...');
    	    return $this->redirectToRoute('login');
    	}
        return $this->render('security/inscription.html.twig',[
        	'form'     => $form->createView(),
        	'error' => null,
            'page_name' => 'la page d\'inscription'
        ]);
    }
}
