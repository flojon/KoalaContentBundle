<?php

namespace Koala\ContentBundle\Entity;

use Symfony\Cmf\Component\Routing\RouteRepositoryInterface;
use Symfony\Component\Routing\Route as SymfonyRoute;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
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

    public function getRouteByName($name, $parameters = array())
    {
        if (0 !== strpos($name, $this->routeNamePrefix)) {
            throw new RouteNotFoundException("Route name '$name' does not begin with the route name prefix '{$this->routeNamePrefix}'");
        }

        $id = substr($name, strlen($this->routeNamePrefix));
        $route = $this->dm->getRepository($this->className)->findOneById($id);
        if (!$route) {
            throw new RouteNotFoundException("No route found for name '$name'");
        }

        return $route;
    }
}
