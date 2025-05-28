<?php

namespace Frosh\PrometheusBundle\DependencyInjection;

use Frosh\PrometheusBundle\Service\MessageCountResolver;
use Prometheus\CollectorRegistry;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Reference;

class FroshPrometheusExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->findTaggedServiceIds('messenger.receiver');

        $container->setDefinition('frosh_prometheus.collector_registry', new Definition(CollectorRegistry::class))
            ->setFactory(sprintf('%s::create', PrometheusRegistryFactory::class))
            ->addArgument($config['storage']['adapter'] ?? 'redis')
            ->addArgument($config['storage']['options'] ?? []);
    }
}
