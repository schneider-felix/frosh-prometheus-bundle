<?php

namespace Frosh\PrometheusBundle\StatsCollector;

use Prometheus\CollectorRegistry;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

abstract class AbstractStatsCollector
{
    public abstract function collect(CollectorRegistry $registry): void;
}
