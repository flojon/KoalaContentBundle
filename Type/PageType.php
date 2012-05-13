<?php
namespace Koala\ContentBundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PageType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder->add('parent', 'entity', array('class'=>'KoalaContentBundle:Page', 'empty_value'=>'-- No parent --'));
		$builder->add('menu_title');
		$builder->add('url');
		$builder->add('slug');
		$builder->add('layout', 'layouts');
	}

	public function getName()
	{
		return 'page';
	}
}