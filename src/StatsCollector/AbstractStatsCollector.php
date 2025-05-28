<?php

namespace Frosh\PrometheusBundle\StatsCollector;

use Prometheus\CollectorRegistry;

abstract class AbstractStatsCollector
{
    public abstract function collect(CollectorRegistry $registry): void;
}
