<?php

namespace Koala\ContentBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('koala_content');

        $supportedDrivers = array('orm');
        $saveMethods = array('put', 'post');

        $rootNode
            ->children()
                ->scalarNode('db_driver')
                    ->defaultValue('orm')
                    ->validate()
                        ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The driver %s is not supported. Please choose one of '.json_encode($supportedDrivers))
                    ->end()
                    ->cannotBeOverwritten()
                ->end()
                ->scalarNode('save_method')
                    ->defaultValue('put')
                    ->validate()
                        ->ifNotInArray($saveMethods)
                        ->thenInvalid('Invalid saveMethod: %s. Please choose one of '.json_encode($saveMethods))
                    ->end()
                ->end()
                ->scalarNode('editor_role')->defaultValue('ROLE_ADMIN')->end()
            ->end()
        ;

        $this->addMercurySection($rootNode);

        return $treeBuilder;
    }
    
    protected function addMercurySection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('mercury')
                    ->children()
                        ->arrayNode('javascripts')
                            ->prototype('scalar')
                            ->end()
                        ->end()
                        ->arrayNode('stylesheets')
                            ->prototype('scalar')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
