<?php

namespace Koala\ContentBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Koala\ContentBundle\Model\Page;

class PageManager extends BaseManager
{
    protected $route_class;

    public function __construct(ObjectManager $om, $class, $route_class)
    {
        parent::__construct($om, $class);

        $this->route_class = $route_class;
    }

    public function createPage()
    {
        $page = new $this->class();
        $page->addRoute(new $this->route_class());

        return $page;
    }

    public function updatePage(Page $page, $flush = true)
    {
        $this->update($page, $flush);
    }

    public function removePage(Page $page, $flush = true)
    {
        $this->remove($page, $flush);
    }

    public function findById($id)
    {
        $page = $this->repository->find($id);

        if (!$page) {
            throw new NotFoundHttpException('404 - Not found!');
        }

        return $page;
    }
}
