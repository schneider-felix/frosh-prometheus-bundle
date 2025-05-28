<?php

namespace Frosh\PrometheusBundle\StatsCollector;

use Composer\Composer;
use Prometheus\CollectorRegistry;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class ShopwareVersionCollector extends AbstractStatsCollector
{

    public function __construct(
        private string $shopwareVersion
    )
    {
    }

    public function collect(CollectorRegistry $registry): void
    {
        $registry->getOrRegisterGauge('frosh', 'shopware_version', 'Shopware version', ['version'])
            ->set(1, ['version' => $this->shopwareVersion]);
    }
}
