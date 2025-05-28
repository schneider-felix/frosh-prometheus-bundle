<?php

namespace Frosh\PrometheusBundle\Routing;

use Frosh\PrometheusBundle\Controller\PrometheusController;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class MetricRouteLoader
{

    public function __construct(
        private string $path
    )
    {
    }

    public function __invoke(): RouteCollection
    {
        $routes = new RouteCollection();
        $routes->add('frosh.prometheus.metrics', new Route(
            $this->path,
            [
                '_routeScope' => ['frosh_prometheus'],
                'auth_required' => false,
                'sw-skip-transformer' => true,
                '_controller' => sprintf('%s::prometheus', PrometheusController::class),
            ],
            methods: ['GET']
        ));

        return $routes;
    }
}
