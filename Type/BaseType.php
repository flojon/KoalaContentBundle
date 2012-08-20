<?php
namespace Koala\ContentBundle\Type;

use Symfony\Component\Form\AbstractType;

abstract class BaseType extends AbstractType
{
    protected $class;

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => $this->class,
        );
    }
}