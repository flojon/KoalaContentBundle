<?php

namespace Koala\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ContentController extends Controller
{
	/**
	* @Route("/content/{slug}")
	* @Template()
	*/
	public function pageAction($slug = "index")
	{
	    $page = $this->getDoctrine()
	        ->getRepository('KoalaContentBundle:Page')
	        ->findOneBySlug($slug);

	    if (!$page) {
	        throw $this->createNotFoundException('404 - Not found!');
	    }
		
		return array('page' => $page);
	}

	/**
	* @Route("/content")
	* @Template()
	*/
	public function indexAction()
	{
		return $this->forward('KoalaContentBundle:Content:page');
	}
	

}
