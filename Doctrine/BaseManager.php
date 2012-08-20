<?php

namespace Koala\ContentBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;

abstract class BaseManager
{
    protected $om;
    protected $class;
    protected $repository;

    public function __construct(ObjectManager $om, $class)
    {
        $this->om = $om;
        $this->repository = $om->getRepository($class);

        $metadata = $om->getClassMetadata($class);
        $this->class = $metadata->getName();
    }

    public function update($object, $flush = true)
    {
        $this->om->persist($object);

        if ($flush)
            $this->om->flush();
    }

    public function remove($object, $flush = true)
    {
        $this->om->remove($object);

        if ($flush)
            $this->om->flush();
    }

    public function flush()
    {
        $this->om->flush();
    }
}
