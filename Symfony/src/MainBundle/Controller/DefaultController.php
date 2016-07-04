<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MainBundle\Entity\Email;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request, $name)
    { 
    	$compteur = "";

    	$repository = $this
		  ->getDoctrine()
		  ->getManager()
		  ->getRepository('MainBundle:Email');

		$email = $repository->find(1);
		// verifie qu'il y a une entree sinon la creee
		if(!$email) {
			$compteur = 0;
		} else {
			$compteur = $email->getCompteur();
		}

    	// Quand on appuie sur le bouton envoyer
    	if ($request->isMethod('POST')) {
    		$message = \Swift_Message::newInstance()
		        ->setSubject('Hello Email')
		        ->setFrom('hoarausamuel@gmail.com')
		        ->setTo('hoarausamuel@gmail.com')
		        ->setBody('hello world !!');
		    $this->get('mailer')->send($message);

		    $em = $this->getDoctrine()->getManager();

		    if(!$email) {
				$email = new Email();
				$email->setCompteur(0);

				$em->persist($email);
			} else {
				$email->setCompteur($email->getCompteur()+1);
			}
			$compteur = $email->getCompteur();

		    $em->flush();
    	}

        return $this->render('MainBundle:Default:index.html.twig', array("compteur"=>$compteur));
    }
}
