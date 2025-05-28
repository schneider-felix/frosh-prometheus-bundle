<?php

namespace Frosh\PrometheusBundle;

use Frosh\PrometheusBundle\DependencyInjection\MessengerCompilerPass;
use Shopware\Core\Framework\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FroshPrometheusBundle extends Bundle
{

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new MessengerCompilerPass());
    }

}
