<?php

namespace Frosh\PrometheusBundle\StatsCollector;

use Prometheus\CollectorRegistry;
use Symfony\Component\Messenger\Transport\Receiver\MessageCountAwareInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;

class MessageCountCollector extends AbstractStatsCollector
{

    public function __construct(
        private iterable $transports,
    )
    {
    }

    public function collect(CollectorRegistry $registry): void
    {
        $messageCountGauge = $registry->getOrRegisterGauge('frosh', 'message_count', 'Number of messages currently in queue', ['transport']);

        /**
         * @var TransportInterface $transport
         */
        foreach ($this->transports as $transportName => $transport) {
            if (!$transport instanceof MessageCountAwareInterface) {
                continue;
            }

            $messageCountGauge->set($transport->getMessageCount(), ['transport' => $transportName]);
        }
    }
}
