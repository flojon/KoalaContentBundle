<?php
namespace Koala\ContentBundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

class PageType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
        $builder->add('parent', 'entity', array(
            'class'=>'KoalaContentBundle:Page',
            'query_builder' =>
                function(NestedTreeRepository $er) {
                    return $er->childrenQueryBuilder();
                }
            )
        );
		$builder->add('menuTitle');
		$builder->add('url');
		$builder->add('slug');
		$builder->add('layout', 'layouts');
	}

	public function getName()
	{
		return 'page';
	}
}