<?php

namespace App\Listeners;

use App\Events\SomeEvent;
use Closure;
use Illuminate\Support\Facades\Log;

class SingleRouteHandler implements RouteInterface
{
    protected const MAX_USE_ROUTE = 10;

    public function __construct
    (
        protected SingleRouteStorage $singleRouteStorage,
    ) {
    }

    public function handle(SomeEvent $event, Closure $next): SomeEvent
    {
        $value = $this->singleRouteStorage->get($event->getUserId(), $event->getRoute());
        if ($value === 0) {
            $this->singleRouteStorage->set($event->getUserId(), $event->getRoute());
        }
        if ($value > 0) {
            $this->singleRouteStorage->incr($event->getUserId(), $event->getRoute());
        }
        if ($value <= self::MAX_USE_ROUTE) {
            return $next($event);
        }
        Log::info('single route');
        return $next($event);
    }
}
