<?php

namespace Frosh\PrometheusBundle\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use function Psl\Example\TCP\request;

class SkipRequestTransformerSubscriber implements EventSubscriberInterface
{

    public function __construct(
        private string $path
    )
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }


    public function onKernelRequest(RequestEvent $event): void
    {
        if($event->getRequest()->getPathInfo() !== $this->path){
            return;
        }

        $event->getRequest()->attributes->set('sw-skip-transformer', true);
    }
}
