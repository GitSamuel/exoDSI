<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
    	$message = \Swift_Message::newInstance()
	        ->setSubject('Hello Email')
	        ->setFrom('send@example.com')
	        ->setTo('recipient@example.com')
	        ->setBody(
	            $this->renderView(
	                // app/Resources/views/Emails/registration.html.twig
	                'Emails/registration.html.twig',
	                array('name' => $name)
	            ),
	            'text/html'
	        );
	    $this->get('mailer')->send($message);

        return $this->render('MainBundle:Default:index.html.twig');
    }
}
