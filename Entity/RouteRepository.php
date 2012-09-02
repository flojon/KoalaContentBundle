<?php

namespace Koala\ContentBundle\Entity;

use Symfony\Cmf\Component\Routing\RouteRepositoryInterface;
use Symfony\Component\Routing\Route as SymfonyRoute;
use Symfony\Component\Routing\RouteCollection;
use Doctrine\Common\Persistence\ObjectManager;

class RouteRepository implements RouteRepositoryInterface
{
    protected $dm;

    protected $className;

    protected $routeNamePrefix = 'koala_content_dynamic_route';

    public function __construct(ObjectManager $dm, $className)
    {
        $this->dm = $dm;
        $this->className = $className;
    }

    function findManyByUrl($url)
    {
        $collection = new RouteCollection();

        $routes = $this->dm->getRepository($this->className)->findByPattern($url);

        foreach ($routes as $route) {
            if ($route instanceof SymfonyRoute) {
                $route->init();
                $collection->add($this->routeNamePrefix . $route->getId(), $route);
            }
        }

        return $collection;
        }

        return $routes;
    }
}
