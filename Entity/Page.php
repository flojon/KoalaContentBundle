<?php
namespace Koala\ContentBundle\Entity;

use Symfony\Cmf\Component\Routing\RouteAwareInterface;

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

    /**
     * Add region
     *
     * @param Koala\ContentBundle\Entity\PageContent $region
     */
    public function addRegion(\Koala\ContentBundle\Entity\Region $region)
    {
        $region->setPage($this);
        $this->regions[] = $region;
    }

    /**
     * Get regions
     *
     * @return Doctrine\Common\Collections\Collection
     */
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

    public function addRoute(Route $route)
    {
        $route->setPage($this);
        $this->routes[] = $route;
    }

    /**
     * Set layout
     *
     * @param string $layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    /**
     * Get layout
     *
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }
}
