<?php

namespace Koala\ContentBundle\Doctrine;

use Koala\ContentBundle\Model\Page;

class RouteManager extends BaseManager
{
    public function findByPattern($pattern)
    {
        return $this->repository->findOneByPattern($pattern);
    }
}