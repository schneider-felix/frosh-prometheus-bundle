<?php

namespace Frosh\PrometheusBundle\StatsCollector;

use Doctrine\DBAL\Connection;
use Prometheus\CollectorRegistry;

class NewsletterCountCollector extends AbstractStatsCollector
{

    public function __construct(
        private Connection $connection
    )
    {
    }

    public function collect(CollectorRegistry $registry): void
    {
        $newsletterCounts = $this->connection->fetchAllKeyValue("SELECT status, COUNT(status) FROM newsletter_recipient GROUP BY status");

        $newsletterRecipientGauge = $registry->getOrRegisterGauge('frosh', 'newsletter_recipient_count', 'Number of newsletter recipients', ['status']);
        foreach ($newsletterCounts as $status => $count) {
            $newsletterRecipientGauge->set($count, ['status' => $status]);
        }
    }
}
