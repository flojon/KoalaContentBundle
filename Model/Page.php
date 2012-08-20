<?php
namespace Koala\ContentBundle\Model;

use Symfony\Cmf\Component\Routing\RouteAwareInterface;
use Symfony\Cmf\Component\Routing\RouteObjectInterface;

class Page implements RouteAwareInterface
{
    protected $id;

    protected $title;

    protected $layout;

    protected $regions;

    protected $menuItems;

    protected $routes;

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function __construct()
    {
        $this->regions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->routes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getTitle();
    }

    public function addRegion(Region $region)
    {
        $region->setPage($this);
        $this->regions[] = $region;
    }

    public function getRegions()
    {
        return $this->regions;
    }

    public function getFirstMenuItem()
    {
        return $this->menuItems[0];
    }

    public function getFirstRoute()
    {
        return $this->routes[0];
    }

    public function getRoutes()
    {
        return $this->routes->toArray();
    }

    public function addRoute(RouteObjectInterface $route)
    {
        $route->setRouteContent($this);
        $this->routes[] = $route;
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function getLayout()
    {
        return $this->layout;
    }
}
