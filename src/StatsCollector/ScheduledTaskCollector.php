<?php

namespace Frosh\PrometheusBundle\StatsCollector;

use Doctrine\DBAL\Connection;
use Prometheus\CollectorRegistry;
use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTaskDefinition;

class ScheduledTaskCollector extends AbstractStatsCollector
{

    public function __construct(
        private readonly Connection $connection
    )
    {
    }

    public function collect(CollectorRegistry $registry): void
    {
        $nextExecutionMetric = $registry->getOrRegisterGauge('frosh', 'scheduled_task_next_execution', '', ['task_class']);
        $lastExecutionMetric = $registry->getOrRegisterGauge('frosh', 'scheduled_task_last_execution', '', ['task_class']);
        $scheduledTaskStateMetric = $registry->getOrRegisterGauge('frosh', 'scheduled_task_state', '', ['task_class']);

        $scheduledTasks = $this->connection->fetchAllAssociativeIndexed(
            "SELECT scheduled_task_class, 
       UNIX_TIMESTAMP(last_execution_time) as last_execution_time, 
       UNIX_TIMESTAMP(next_execution_time) as next_execution_time, 
       status FROM scheduled_task");


        foreach ($scheduledTasks as $scheduledTaskClass => $scheduledTaskState) {
            $nextExecutionMetric->set(round($scheduledTaskState['next_execution_time']), [
                'task_class' => $scheduledTaskClass
            ]);

            $lastExecutionMetric->set(round($scheduledTaskState['last_execution_time']), [
                'task_class' => $scheduledTaskClass
            ]);

            $scheduledTaskStateMetric->set(match($scheduledTaskState['status']) {
                ScheduledTaskDefinition::STATUS_SCHEDULED => 0,
                ScheduledTaskDefinition::STATUS_FAILED => 1,
                ScheduledTaskDefinition::STATUS_INACTIVE => 2,
                ScheduledTaskDefinition::STATUS_QUEUED => 3,
                ScheduledTaskDefinition::STATUS_RUNNING => 4,
                ScheduledTaskDefinition::STATUS_SKIPPED => 5,
                default => -1,
            }, ['task_class' => $scheduledTaskClass]);
        }

    }
}
