<?php

namespace Koala\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Koala\ContentBundle\Entity\Page;
use Koala\ContentBundle\Entity\Region;
use Koala\ContentBundle\Type\PageType;

class PageController extends SecuredController
{
    /**
     * @Route("/new")
     * @Template()
     * @Method("GET")
     */
    public function newAction(Request $request)
    {
        $page = new Page();
        $form = $this->createForm(new PageType(), $page);

        return array('form'=>$form->createView());
    }

    /**
     * @Route("/new")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $page = new Page();
        $form = $this->createForm(new PageType(), $page);

        $form->bindRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($page);
            $em->flush();
            return $this->redirect($this->generateUrl('koala_content_page_show', array('url'=>$page->getUrl())));
        }

        return $this->render('KoalaContentBundle:Page:new.html.twig', array('form'=>$form->createView()));
    }

    /**
     * @Route("/{url}", defaults={"url"="/"}, requirements={"url"=".+"})
     * @Method("GET")
     */
    public function showAction($url = "/")
    {
        $repo = $this->getDoctrine()
            ->getRepository('KoalaContentBundle:Page');

        $page = $this->getPage($url);

        $regions = array();
        foreach ($page->getRegions() as $r)
        {
            $regions[$r->getName()] = $r->getContent();
        }

        $factory = $this->container->get('knp_menu.factory');
        $menu = $factory->createItem('root');
        $menu->setCurrentUri($this->container->get('request')->getRequestUri());
        foreach ($repo->getRootNodes() as $root)
        {
            $menu->addChild($factory->createFromNode($root));
        }

        $template = $this->get('layouts_provider')->getTemplate($page->getLayout());

        return $this->render($template, array('page' => $page, 'regions' => $regions, 'menu'=>$menu, 'can_edit'=>$this->can_edit()));
    }

    protected function getPage($url)
    {
        $page = $this->getDoctrine()->getRepository('KoalaContentBundle:Page')->findOneByUrl($url);

        if (!$page) {
            throw $this->createNotFoundException('404 - Not found!');
        }

        return $page;
    }
}
