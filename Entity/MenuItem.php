<?php
namespace Koala\ContentBundle\Entity;

use Knp\Menu\NodeInterface;

class MenuItem implements NodeInterface
{
    protected $id;

    private $lft;

    private $lvl;

    private $rgt;

    private $root;

    private $parent;

    private $children;

    protected $label;

    protected $page;

    public function __toString()
    {
        return $this->getLabel();
    }

    /**
     * Get the name of the node
     *
     * Each child of a node must have a unique name
     *
     * @return string
     */
    function getName()
    {
        return $this->getLabel();
    }

    /**
     * Get the options for the factory to create the item for this node
     *
     * @return array
     */
    function getOptions()
    {
        $options = array(
            'label' => $this->getLabel(),
        );

        if ($this->page !== null) {
            $options['route'] = 'koala_content_page_show';
            $options['routeParameters'] = array('url' => $this->page->getUrl());
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

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLft($lft)
    {
        $this->lft = $lft;
    }

    public function getLft()
    {
        return $this->lft;
    }

    public function setLvl($lvl)
    {
        $this->lvl = $lvl;
    }

    public function getLvl()
    {
        return $this->lvl;
    }

    public function setRgt($rgt)
    {
        $this->rgt = $rgt;
    }

    public function getRgt()
    {
        return $this->rgt;
    }

    public function setRoot($root)
    {
        $this->root = $root;
    }

    public function getRoot()
    {
        return $this->root;
    }

    public function setParent(\Koala\ContentBundle\Entity\MenuItem $parent)
    {
        $this->parent = $parent;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function addMenuItem(\Koala\ContentBundle\Entity\MenuItem $menuItem)
    {
        $this->children[] = $menuItem;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function setPage(Page $page)
    {
        $this->page = $page;
    }
}
