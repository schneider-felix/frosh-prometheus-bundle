<?php

namespace Frosh\PrometheusBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MessengerCompilerPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        $transportIds = array_keys($container->findTaggedServiceIds('messenger.receiver'));
        $transportServiceReferences = [];
        foreach ($transportIds as $transportId) {
            if(!$container->hasDefinition($transportId)){
                continue;
            }
            $transportServiceReferences[$transportId] = new Reference($transportId);
        }

        $container->getDefinition('Frosh\PrometheusBundle\StatsCollector\MessageCountCollector')
            ->replaceArgument(0, $transportServiceReferences);
    }
}
