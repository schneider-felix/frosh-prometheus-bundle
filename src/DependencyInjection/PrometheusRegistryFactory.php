<?php

namespace Frosh\PrometheusBundle\DependencyInjection;

use Prometheus\CollectorRegistry;
use Prometheus\Storage\Redis;

class PrometheusRegistryFactory
{

    public static function create(string $adapter, array $options)
    {
        $storageAdapter = match($adapter) {
            'redis' => new Redis($options),
            default => throw new \RuntimeException(sprintf('Adapter %s is not supported', $adapter)),
        };

        return new CollectorRegistry($storageAdapter, false);
    }

}
