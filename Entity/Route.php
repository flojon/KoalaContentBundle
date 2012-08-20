<?php

namespace Koala\ContentBundle\Entity;

use Symfony\Component\Routing\Route as SymfonyRoute;
use Symfony\Cmf\Component\Routing\RouteObjectInterface;

class Route extends SymfonyRoute implements RouteObjectInterface
{
    protected $id;

    protected $pattern;

    protected $page;

    public function __construct()
    {
        $this->init();
    }

    public function __toString()
    {
        return $this->pattern;
    }

    public function init()
    {
        $this->setDefaults(array());
        $this->setRequirements(array());
        $this->setOptions(array());
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRouteContent()
    {
        return $this->page;
    }

    public function getPattern()
    {
        return $this->pattern;
    }

    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function setRouteContent(Page $page)
    {
        $this->page = $page;
    }
}
