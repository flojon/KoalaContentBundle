<?php

namespace Koala\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Koala\ContentBundle\Entity\Page;
use Koala\ContentBundle\Entity\Route;
use Koala\ContentBundle\Entity\MenuItem;

class PageController extends SecuredController
{
    /**
     * @Template()
     */
    public function newAction(Request $request)
    {
        if (!$this->can_edit()) {
            throw new \Exception('Permission denied');
        }

        $page = new Page();
        $menuItem = new MenuItem();
        $page->addRoute(new Route());
        $menuItem->setContent($page);
        $form = $this->createForm('menuItem', $menuItem);

        return array('form'=>$form->createView());
    }

    public function createAction(Request $request)
    {
        if (!$this->can_edit()) {
            throw new \Exception('Permission denied');
        }

        $page = new Page();
        $menuItem = new MenuItem();
        $page->addRoute(new Route());
        $menuItem->setContent($page);
        $form = $this->createForm('menuItem', $menuItem);

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($menuItem);
            $em->flush();

            return $this->redirect($this->generateUrl(null, array('content'=>$menuItem->getContent())));
        }

        return $this->render('KoalaContentBundle:Page:new.html.twig', array('form'=>$form->createView()));
    }

    /**
     * @Template()
     */
    public function editAction($page_id)
    {
        if (!$this->can_edit()) {
            throw new \Exception('Permission denied');
        }

        $menuItem = $this->getPage($page_id)->getFirstMenuItem();
        $form = $this->createForm('menuItem', $menuItem);

        return array('form'=>$form->createView());
    }

    public function updateAction(Request $request, $page_id)
    {
        if (!$this->can_edit()) {
            throw new \Exception('Permission denied');
        }

        $menuItem = $this->getPage($page_id)->getFirstMenuItem();
        $form = $this->createForm('menuItem', $menuItem);

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->flush();

            return $this->redirect($this->generateUrl(null, array('content'=>$menuItem->getContent())));
        }

        return $this->render('KoalaContentBundle:Page:edit.html.twig', array('form'=>$form->createView()));
    }

    public function deleteAction($page_id)
    {
        if (!$this->can_edit()) {
            throw new \Exception('Permission denied');
        }

        $page = $this->getPage($page_id);
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($page);
        $em->flush();

        return $this->redirect($this->generateUrl(null, array(
            'route' => $this->getDoctrine()->getRepository('KoalaContentBundle:Route')->findOneByPattern('/')
        )));
    }

    /**
     * @Template()
     */
    public function showAction($contentDocument)
    {
        $regions = array();
        foreach ($contentDocument->getRegions() as $r) {
            $regions[$r->getName()] = $r->getContent();
        }

        $template = $this->get('layouts_provider')->getTemplate($contentDocument->getLayout());

        return array('page' => $contentDocument, 'regions' => $regions, 'template' => $template, 'can_edit'=>$this->can_edit());
    }

    protected function getPage($page_id)
    {
        $page = $this->getDoctrine()->getRepository('KoalaContentBundle:Page')->find($page_id);

        if (!$page) {
            throw $this->createNotFoundException('404 - Not found!');
        }

        return $page;
    }
}
