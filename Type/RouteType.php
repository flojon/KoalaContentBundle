<?php
namespace Koala\ContentBundle\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormBuilder;

class RouteType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('pattern', 'text', array('label'=>'URL'));
    }

    public function getName()
    {
        return 'route';
    }
}
