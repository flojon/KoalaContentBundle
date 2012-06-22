<?php

namespace Koala\ContentBundle\Entity;

use Symfony\Cmf\Component\Routing\RouteRepositoryInterface;
use Doctrine\Common\Persistence\ObjectManager;

class RouteRepository implements RouteRepositoryInterface
{
    protected $dm;

    protected $className;

    public function __construct(ObjectManager $dm, $className)
    {
        $this->dm = $dm;
        $this->className = $className;
    }

    function findManyByUrl($url)
    {
        $routes = $this->dm->getRepository($this->className)->findByPattern($url);

        if (!$routes)
            $routes = array();

        foreach ($routes as $route) {
            $route->init();
        }

        return $routes;
    }
}
