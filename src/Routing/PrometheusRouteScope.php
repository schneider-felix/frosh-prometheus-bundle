<?php

namespace Frosh\PrometheusBundle\Routing;

use Shopware\Core\Framework\Routing\AbstractRouteScope;
use Symfony\Component\HttpFoundation\Request;

class PrometheusRouteScope extends AbstractRouteScope
{

    final public const ID = 'frosh_prometheus';

    public function __construct(private string $prometheusPath)
    {
    }

    public function isAllowedPath(string $path): bool
    {
        return $path === $this->prometheusPath;
    }

    public function isAllowed(Request $request): bool
    {
        return true;
    }

    public function getId(): string
    {
        return self::ID;
    }
}
