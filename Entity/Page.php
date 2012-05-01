<?php
namespace Koala\ContentBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Page
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 */

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $menu_title;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $slug;

	/**
	 * @ORM\Column(type="string", length=128)
	 */
	protected $url;

	/**
	 * @ORM\Column(type="string")
	 */
	protected $background_url;

	/**
	 * @ORM\OneToMany(targetEntity="Region", mappedBy="page")
	 */
	protected $regions;

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

	/**
	 * Set content
	 *
	 * @param text $content
	 */
	public function setContent($content)
	{
		$this->content = $content;
	}

	/**
	 * Get content
	 *
	 * @return text
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * Set background_url
	 *
	 * @param string $backgroundUrl
	 */
	public function setBackgroundUrl($backgroundUrl)
	{
		$this->background_url = $backgroundUrl;
	}

	/**
	 * Get background_url
	 *
	 * @return string
	 */
	public function getBackgroundUrl()
	{
		return $this->background_url;
	}

	public function __construct()
	{
		$this->regions = new \Doctrine\Common\Collections\ArrayCollection();
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
}