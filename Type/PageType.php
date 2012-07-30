<?php
namespace Koala\ContentBundle\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title');
        $builder->add('layout', 'layouts');
        $builder->add('routes', 'collection', array('type' => new RouteType()));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Koala\ContentBundle\Entity\Page',
        );
    }

    public function getName()
    {
        return 'page';
    }
}
