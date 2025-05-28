<?php

namespace Frosh\PrometheusBundle\StatsCollector;

use Doctrine\DBAL\Connection;
use Prometheus\CollectorRegistry;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\Uuid\Uuid;

class OrderCountCollector extends AbstractStatsCollector
{

    public function __construct(
        private Connection $connection
    )
    {
    }

    public function collect(CollectorRegistry $registry): void
    {
        $orderCount = $this->connection->fetchOne("SELECT COUNT(*) FROM `order` WHERE version_id = :liveVersion", [
            'liveVersion' => Uuid::fromHexToBytes(Defaults::LIVE_VERSION)
        ]);

        // While a counter might seem more appropriate here, orders can be deleted so it would not be a good fit
        $registry->getOrRegisterGauge('frosh', 'order_count', 'Number of orders currently in database')
            ->set($orderCount);
    }

}
