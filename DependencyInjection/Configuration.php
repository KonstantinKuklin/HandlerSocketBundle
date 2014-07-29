<?php

namespace KonstantinKuklin\HandlerSocketBundle\DependencyInjection;

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
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('hs');
        $rootNode
            ->children()
                ->arrayNode('reader')
                    ->children()
                        ->scalarNode("host")->cannotBeEmpty()->end()
                        ->integerNode("port")->min(1)->max(65535)->end()
                        ->scalarNode("auth_key")->defaultNull()->end()
                    ->end()
                ->end()
                ->arrayNode('writer')
                    ->children()
                        ->scalarNode("host")->cannotBeEmpty()->end()
                        ->integerNode("port")->min(1)->max(65535)->end()
                        ->scalarNode("auth_key")->defaultNull()->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
