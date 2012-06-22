<?php
namespace Koala\ContentBundle\Entity;

class Page
{
    protected $id;

    protected $title;

    protected $slug;

    protected $url;

    protected $layout;

    protected $regions;

    protected $menuItems;

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

    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    public function __construct()
    {
        $this->regions = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Set url
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
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
