<?php
namespace Koala\ContentBundle\Entity;

class Region
{
    protected $id;

    protected $name;

    protected $content;

    protected $page;

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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * Set page
     *
     * @param Koala\ContentBundle\Entity\Page $page
     */
    public function setPage(\Koala\ContentBundle\Entity\Page $page)
    {
        $this->page = $page;
    }

    /**
     * Get page
     *
     * @return Koala\ContentBundle\Entity\Page
     */
    public function getPage()
    {
        return $this->page;
    }
}
