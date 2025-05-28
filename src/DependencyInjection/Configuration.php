<?php

namespace Frosh\PrometheusBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('frosh_prometheus');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('storage')
                    ->children()
                        ->stringNode('adapter')->defaultValue('redis')->end()
                        ->arrayNode('options')->end()
                    ->end()
                ->end()
            ->end()
            ;

        return $treeBuilder;
    }
}
