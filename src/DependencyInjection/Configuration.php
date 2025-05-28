<?php

declare(strict_types=1);

namespace Frosh\PrometheusBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('frosh_prometheus');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->arrayNode('allowed_ips')
                    ->stringPrototype()
                    ->defaultValue(["127.0.0.1", "::1"])
                    ->info('IPs that are allowed to access the metrics endpoint')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
