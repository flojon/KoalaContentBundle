<?php

namespace Koala\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Koala\ContentBundle\Entity\Region;

class ContentController extends Controller
{
	/**
	 * @Route("/content/{slug}", defaults={"slug"="index"})
	 * @Method("GET")
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

		$regions = array();
		foreach ($page->getRegions() as $r)
		{
			$regions[$r->getName()] = $r->getContent();
		}

		return array('page' => $page, 'regions' => $regions);
	}

	/**
	 * @Route("/content/{slug}", defaults={"slug"="index"})
	 * @Method("POST")
	 */
	public function editPage(Request $request, $slug = "index")
	{
		$em = $this->getDoctrine()->getEntityManager();
		$page = $em->getRepository('KoalaContentBundle:Page')->findOneBySlug($slug);

		if ($request->isXmlHttpRequest()) { // Mercury save
			if (!$page) {
				return new Response("", 404);
			}

			$content = $request->get('content');
			if (!empty($content))
			{
				$params = json_decode($content, true);

				foreach ($page->getRegions() as $region)
				{
					$name = $region->getName();
					$region->setContent($params['page-'.$name]['value']);
					unset($params['page-'.$name]);
				}
				foreach ($params as $id=>$value)
				{
					list($prefix, $name) = explode('-', $id, 2);
					if ($prefix != 'page')
						continue;
					$region = new Region();
					$region->setName($name);
					$region->setContent($value['value']);
					$em->persist($region);
					$page->addRegion($region);
				}

				$em->flush();

				$response = new Response("");
				$response->headers->set('Content-Type', 'application/json');
				return $response;
			}

			return new Response("", 200);
		}
	}
}
