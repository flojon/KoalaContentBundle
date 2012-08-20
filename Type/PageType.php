<?php
namespace Koala\ContentBundle\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormBuilder;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

class PageType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title');
        $builder->add('layout', 'layouts');
        $builder->add('routes', 'collection', array('type' => 'route'));
    }

    public function getName()
    {
        return 'page';
    }
}
