<?php

namespace Frosh\PrometheusBundle\Controller;

use Frosh\PrometheusBundle\StatsCollector\AbstractStatsCollector;
use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\InMemory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\IpUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(defaults: ['_routeScope' => ['api']])]
class PrometheusController extends AbstractController
{
    /**
     * @param iterable<AbstractStatsCollector> $statsResolvers
     */
    public function __construct(
        private readonly iterable $statsResolvers,
        private array $allowedIps,
    ) {
    }

    #[Route('/api/_info/metrics', name: 'frosh.prometheus.metrics', defaults: ['auth_required' => false], methods: ['GET'])]
    public function prometheus(Request $request): Response
    {
        if(!IpUtils::checkIp($request->getClientIp(), $this->allowedIps)){
            return new Response("", Response::HTTP_NOT_FOUND);
        }

        $collector = new CollectorRegistry(new InMemory(), false);
        foreach ($this->statsResolvers as $statsResolver) {
            $statsResolver->collect($collector);
        }

        $renderer = new RenderTextFormat();

        return new Response(
            $renderer->render($collector->getMetricFamilySamples()),
            Response::HTTP_OK,
            ['Content-Type' => RenderTextFormat::MIME_TYPE]
        );
    }
}
