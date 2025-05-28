<?php

namespace Frosh\PrometheusBundle\StatsCollector;

use Doctrine\DBAL\Connection;
use Prometheus\CollectorRegistry;

class PluginVersionCollector extends AbstractStatsCollector
{

    public function __construct(
        private Connection $connection
    )
    {
    }

    public function collect(CollectorRegistry $registry): void
    {
        $plugins = $this->connection->fetchAllAssociative('SELECT name, active, version FROM `plugin`');

        $pluginActiveGauge = $registry->getOrRegisterGauge(
            'frosh',
            'plugin_active',
            'Plugin version',
            ['name', 'version']
        );

        foreach ($plugins as $plugin) {
            $pluginActiveGauge->set($plugin['active'], [
                'name' => $plugin['name'],
                'version' => $plugin['version']
            ]);
        }
    }
}
