<?php

namespace Koala\ContentBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

use Symfony\Cmf\Bundle\RoutingExtraBundle\Routing\DynamicRouter;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class KoalaContentExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('koala_content.editor_role', $config['editor_role']);
        $container->setParameter('koala_content.save_method', $config['save_method']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $loader->load($config['db_driver'] . ".yml");

        if (class_exists('Symfony\\Cmf\\Bundle\\RoutingExtraBundle\\Routing\\DynamicRouter')) {
            $container->setParameter($this->getAlias() . '.content_key', DynamicRouter::CONTENT_KEY);
        }

        if (!empty($config['mercury'])) {
            if ($container->hasParameter('mercury_twig_extension.package')) {
                $config['mercury'] = array_merge_recursive($container->getParameter('mercury_twig_extension.package'), $config['mercury']);
            }
            $container->setParameter('mercury_twig_extension.package', $config['mercury']);
        }
    }
}
