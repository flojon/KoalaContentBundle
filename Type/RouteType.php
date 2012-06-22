<?php
namespace Koala\ContentBundle\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class RouteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('pattern', 'text', array('label'=>'URL'));
    }

    public function getDefaultOptions()
    {
        return array(
            'data_class' => 'Koala\ContentBundle\Entity\Route',
        );
    }

    public function getName()
    {
        return 'route';
    }
}
