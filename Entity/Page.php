<?php
namespace Koala\ContentBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Knp\Menu\NodeInterface;

class Page implements NodeInterface
{
	protected $id;

	private $lft;

	private $lvl;

	private $rgt;

	private $root;

	private $parent;

	private $children;

	protected $menuTitle;

	protected $slug;

	protected $url;
	
	protected $layout;

	protected $regions;

	/**
	 * Get the name of the node
	 *
	 * Each child of a node must have a unique name
	 *
	 * @return string
	 */
	function getName()
	{
		return $this->getMenuTitle();
	}

	/**
	 * Get the options for the factory to create the item for this node
	 *
	 * @return array
	 */
	function getOptions()
	{
	    $options = array();

	    if (($url = $this->getUrl()) !== null)
	    {
	        $options['route'] = 'koala_content_page_show';
	        $options['routeParameters'] = array('url' => $url);
	    }

	    return $options;
	}

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set menu_title
	 *
	 * @param string $menuTitle
	 */
	public function setMenuTitle($menuTitle)
	{
		$this->menuTitle = $menuTitle;
	}

	/**
	 * Get menu_title
	 *
	 * @return string
	 */
	public function getMenuTitle()
	{
		return $this->menuTitle;
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
		return $this->getMenuTitle();
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

	/**
	 * Set lft
	 *
	 * @param integer $lft
	 */
	public function setLft($lft)
	{
		$this->lft = $lft;
	}

	/**
	 * Get lft
	 *
	 * @return integer
	 */
	public function getLft()
	{
		return $this->lft;
	}

	/**
	 * Set lvl
	 *
	 * @param integer $lvl
	 */
	public function setLvl($lvl)
	{
		$this->lvl = $lvl;
	}

	/**
	 * Get lvl
	 *
	 * @return integer
	 */
	public function getLvl()
	{
		return $this->lvl;
	}

	/**
	 * Set rgt
	 *
	 * @param integer $rgt
	 */
	public function setRgt($rgt)
	{
		$this->rgt = $rgt;
	}

	/**
	 * Get rgt
	 *
	 * @return integer
	 */
	public function getRgt()
	{
		return $this->rgt;
	}

	/**
	 * Set root
	 *
	 * @param integer $root
	 */
	public function setRoot($root)
	{
		$this->root = $root;
	}

	/**
	 * Get root
	 *
	 * @return integer
	 */
	public function getRoot()
	{
		return $this->root;
	}

	/**
	 * Set parent
	 *
	 * @param Koala\ContentBundle\Entity\Page $parent
	 */
	public function setParent(\Koala\ContentBundle\Entity\Page $parent)
	{
		$this->parent = $parent;
	}

	/**
	 * Get parent
	 *
	 * @return Koala\ContentBundle\Entity\Page
	 */
	public function getParent()
	{
		return $this->parent;
	}

	/**
	 * Get children
	 *
	 * @return Doctrine\Common\Collections\Collection
	 */
	public function getChildren()
	{
		return $this->children;
	}

	/**
	 * Add children
	 *
	 * @param Koala\ContentBundle\Entity\Page $children
	 */
	public function addPage(\Koala\ContentBundle\Entity\Page $children)
	{
		$this->children[] = $children;
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