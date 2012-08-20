<?php

namespace Koala\ContentBundle\Doctrine;

use Koala\ContentBundle\Model\Page;

class RegionManager extends BaseManager
{
    public function createRegion()
    {
        return new $this->class;
    }
}