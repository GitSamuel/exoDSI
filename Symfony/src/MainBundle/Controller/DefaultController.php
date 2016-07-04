<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MainBundle\Entity\Email;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
    	$message = \Swift_Message::newInstance()
	        ->setSubject('Hello Email')
	        ->setFrom('hoarausamuel@gmail.com')
	        ->setTo('hoarausamuel@gmail.com')
	        ->setBody('hello world !!');
	    $this->get('mailer')->send($message);

	    $em = $this->getDoctrine()->getManager();

	    $repository = $this
		  ->getDoctrine()
		  ->getManager()
		  ->getRepository('MainBundle:Email');

		$email = $repository->find(1);
		$email->setCompteur($email->getCompteur()+1);
		echo $email->getCompteur();

	    $em->flush();

        return $this->render('MainBundle:Default:index.html.twig');
    }
}
