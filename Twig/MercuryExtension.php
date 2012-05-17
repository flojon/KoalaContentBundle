<?php
namespace Koala\ContentBundle\Twig;

/**
 * Twig Extension to output Mercury Regions
 */
class MercuryExtension extends \Twig_Extension
{
    var $defaults;
    
    public function __construct($template, $defaults = array())
    {
        $this->defaults = array_merge(array(
            'template' => $template,
        ), $defaults);
    }

    public function getFunctions()
    {
        return array(
            'mercury_*' => new \Twig_Function_Method($this, 'mercury_region', array('is_safe' => array('html'), 'needs_environment' => true, 'needs_context' => true)),
        );
    }

    /**
     * Render a mercury region
     *
     * @param $env Twig Environment
     * @param $context Twig context
     * @param $type Mercury region type (simple, image, editable, ...)
     * @param $name Region name, used as id for the block
     * @param $options Extra options,
     *          tag: HTML tag to use (default is div)
     *          class: extra CSS classes for the block
     *          style: CSS style attribute for the block
     *          default: Default content if region is undefined
     *          template: Replace default Twig template
     * @return string HTML block
     */
    public function mercury_region(\Twig_Environment $env, $context, $type, $name, $options = array())
    {
        $options = array_merge($this->defaults, $options);
    
        $template = $options['template'];
        if (!$template instanceof \Twig_Template) {
            $template = $env->loadTemplate($template);
        }

        $options['id'] = $name;
        $options['type'] = $type;
        $options['content'] = empty($context['regions'][$name]) ? $options['default'] : $context['regions'][$name];

        return $template->renderBlock($type, $options);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mercury';
    }
}
