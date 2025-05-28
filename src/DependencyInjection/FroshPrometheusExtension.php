<?php

declare(strict_types=1);

namespace Frosh\PrometheusBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class FroshPrometheusExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('frosh_prometheus.metrics_route', '/' . ltrim(rtrim($config['metrics_route'] ?? '/metrics', '/'), '/'));

        $allowedIps = !empty($config['allowed_ips']) ? $config['allowed_ips'] : [
            '127.0.0.1',
            '::1',
        ];

        $container->setParameter('frosh_prometheus.allowed_ips', $allowedIps);
    }
}
