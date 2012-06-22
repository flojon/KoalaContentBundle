<?php

namespace Koala\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Koala\ContentBundle\Entity\MenuItem;
use Koala\ContentBundle\Type\MenuItemType;

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

        $menuItem = new MenuItem();
        $form = $this->createForm(new MenuItemType(), $menuItem);

        return array('form'=>$form->createView());
    }

    public function createAction(Request $request)
    {
        if (!$this->can_edit()) {
            throw new \Exception('Permission denied');
        }

        $menuItem = new MenuItem();
        $form = $this->createForm(new MenuItemType(), $menuItem);

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($menuItem);
            $em->flush();

            return $this->redirect($this->generateUrl('koala_content_page_show', array('url'=>$menuItem->getPage()->getUrl())));
        }

        return $this->render('KoalaContentBundle:Page:new.html.twig', array('form'=>$form->createView()));
    }

    /**
     * @Template()
     */
    public function editAction($url = "/")
    {
        if (!$this->can_edit()) {
            throw new \Exception('Permission denied');
        }

        $menuItem = $this->getPage($url)->getFirstMenuItem();
        $form = $this->createForm(new MenuItemType(), $menuItem);

        return array('form'=>$form->createView());
    }

    public function updateAction(Request $request, $url = "/")
    {
        if (!$this->can_edit()) {
            throw new \Exception('Permission denied');
        }

        $menuItem = $this->getPage($url)->getFirstMenuItem();
        $form = $this->createForm(new MenuItemType(), $menuItem);

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->flush();

            return $this->redirect($this->generateUrl('koala_content_page_show', array('url'=>$menuItem->getPage()->getUrl())));
        }

        return $this->render('KoalaContentBundle:Page:edit.html.twig', array('form'=>$form->createView()));
    }

    public function deleteAction($url = "/")
    {
        if (!$this->can_edit()) {
            throw new \Exception('Permission denied');
        }

        $page = $this->getPage($url);
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($page);
        $em->flush();

        return $this->redirect($this->generateUrl('koala_content_page_show'));
    }

    /**
     * @Template()
     */
    public function showAction($url = "/")
    {
        $repo = $this->getDoctrine()
            ->getRepository('KoalaContentBundle:Page');

        $page = $this->getPage($url);

        $regions = array();
        foreach ($page->getRegions() as $r) {
            $regions[$r->getName()] = $r->getContent();
        }

        $template = $this->get('layouts_provider')->getTemplate($page->getLayout());

        return array('page' => $page, 'regions' => $regions, 'template' => $template, 'can_edit'=>$this->can_edit());
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
