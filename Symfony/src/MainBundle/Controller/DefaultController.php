<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MainBundle\Entity\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
	/*
	*	Actions
	*/

    public function sendAction(Request $request)
    { 
    	// Quand on appuie sur le bouton envoyer
    	if ($request->isMethod('POST')) {
    		$message = \Swift_Message::newInstance()
		        ->setSubject('Hello Email')
		        ->setFrom('hoarausamuel@gmail.com')
		        ->setTo('hoarausamuel@gmail.com')
		        ->setBody('hello world !!');
		    $this->get('mailer')->send($message);

		    // On récupére l'entité du compteur
		    $repository = $this
			  ->getDoctrine()
			  ->getManager()
			  ->getRepository('MainBundle:Email');
			$email = $repository->find(1);

		    $em = $this->getDoctrine()->getManager();

		    // On initialise le compteur a 0 s'il existe pas ou on incrémente de 1
		    if(!$email) {
				$email = new Email();
				$email->setCompteur(0);

				$em->persist($email);
			} else {
				$email->setCompteur($email->getCompteur()+1);
			}

		    $em->flush();
    	}

        return $this->render('MainBundle:Default:index.html.twig');
    }

    public function getCompteurAction(){

		$response = new JsonResponse();
		$response->setData(array(
		    'compteur' => $this->getCompteur()
		));

		return $response;
    }

    /*
	*	Methode Privées
    */

    private function getCompteur(){
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

		return $compteur;
    }
}
