<?php

namespace Daemon\SimplifyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('daemon_simplify');

        $rootNode
            ->children()
                ->arrayNode('valid_entities')
                    ->prototype('scalar')
                    ->example(array('- EntityName'))
                ->end()
            ->end()
            ;
        $rootNode
            ->children()
                ->arrayNode('view_context')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('INDEX')
                            ->defaultValue('index')
                        ->end()
                        ->scalarNode('CREATE')
                            ->defaultValue('create')
                        ->end()
                        ->scalarNode('SHOW')
                            ->defaultValue('show')
                        ->end()
                            ->scalarNode('UPDATE')
                        ->defaultValue('update')
                            ->end()
                        ->scalarNode('DELETE')
                            ->defaultValue('delete')
                        ->end()
                    ->end()
                ->end()
            ->end();
        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
