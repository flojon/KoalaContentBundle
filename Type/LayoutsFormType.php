<?php
namespace Koala\ContentBundle\Type;

use Symfony\Component\Form\AbstractType;

class LayoutsFormType extends AbstractType
{
    var $provider;

    public function __construct($provider)
    {
        $this->provider = $provider;
    }

    public function getDefaultOptions(array $options = null)
    {
        return array(
            'choices' => $this->provider->getChoices(),
        );
    }

    public function getParent(array $options)
    {
        return 'choice';
    }

    public function getName()
    {
        return 'layout';
    }
}
