<?php

namespace Koala\ContentBundle\Doctrine;

use Koala\ContentBundle\Model\Page;

class MenuItemManager extends BaseManager
{
    public function createMenuItem(Page $page)
    {
        $menuItem = new $this->class();
        $menuItem->setContent($page);

        return $menuItem;
    }

    public function updateMenuItem($menu_item, $flush = true)
    {
        $this->update($menu_item, $flush);
    }

    public function removeMenuItem($menu_item, $flush = true)
    {
        $this->remove($menu_item, $flush);
    }
}
