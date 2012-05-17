<?php
namespace Koala\ContentBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\Menu\NodeInterface;

/**
 * @Gedmo\Tree(type="nested")
 * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\NestedTreeRepository")
 */
class Page implements NodeInterface
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @Gedmo\TreeLeft
	 * @ORM\Column(name="lft", type="integer")
	 */
	private $lft;

	/**
	 * @Gedmo\TreeLevel
	 * @ORM\Column(name="lvl", type="integer")
	 */
	private $lvl;

	/**
	 * @Gedmo\TreeRight
	 * @ORM\Column(name="rgt", type="integer")
	 */
	private $rgt;

	/**
	 * @Gedmo\TreeRoot
	 * @ORM\Column(name="root", type="integer", nullable=true)
	 */
	private $root;

	/**
	 * @Gedmo\TreeParent
	 * @ORM\ManyToOne(targetEntity="Page", inversedBy="children")
	 * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
	 */
	private $parent;

	/**
	 * @ORM\OneToMany(targetEntity="Page", mappedBy="parent")
	 * @ORM\OrderBy({"lft" = "ASC"})
	 */
	private $children;

	/**
	 * @ORM\Column(type="string", length=100)
	 * @Assert\NotBlank
	 */
	protected $menu_title;

	/**
	 * @Gedmo\Slug(fields={"menu_title"})
	 * @ORM\Column(length=128, unique=true)
	 */
	protected $slug;

	/**
     * @ORM\Column(type="string", length=128, unique=true)
	 * @Assert\NotBlank
	 */
	protected $url;
	
	/**
	 * Specifies template used for rendering the page
	 *
	 * @ORM\Column(type="string")
	 */
	protected $layout;

	/**
	 * @ORM\OneToMany(targetEntity="Region", mappedBy="page")
	 */
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
		return array(
			'route'=>'koala_content_page_show',
			'routeParameters' => array('url' => $this->getUrl()),
		);
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
		$this->menu_title = $menuTitle;
	}

	/**
	 * Get menu_title
	 *
	 * @return string
	 */
	public function getMenuTitle()
	{
		return $this->menu_title;
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