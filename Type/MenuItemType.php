<?php
namespace Koala\ContentBundle\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

class MenuItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('parent', 'entity', array(
            'class'=>'Koala\ContentBundle\Entity\MenuItem',
            'query_builder' =>
                function(NestedTreeRepository $er) {
                    return $er->childrenQueryBuilder();
                }
            )
        );
        $builder->add('label');
        $builder->add('content', new PageType());
    }

    public function getName()
    {
        return 'menuItem';
    }
}
