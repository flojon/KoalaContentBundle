<?php
namespace Koala\ContentBundle\Model;

class Region
{
    protected $id;

    protected $name;

    protected $content;

    protected $page;

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setPage(Page $page)
    {
        $this->page = $page;
    }

    public function getPage()
    {
        return $this->page;
    }
}
