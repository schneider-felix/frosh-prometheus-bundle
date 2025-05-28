<?php

namespace Frosh\PrometheusBundle;

use Frosh\PrometheusBundle\DependencyInjection\FroshPrometheusExtension;
use Frosh\PrometheusBundle\DependencyInjection\MessengerCompilerPass;
use Shopware\Core\Framework\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class FroshPrometheusBundle extends Bundle
{

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new MessengerCompilerPass());
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new FroshPrometheusExtension();
    }
}
