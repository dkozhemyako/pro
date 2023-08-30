<?php

namespace App\Listeners;

use App\Events\SomeEvent;
use Closure;
use Illuminate\Support\Facades\Log;

class MultipleRouteHandler implements RouteInterface
{
    protected const MAX_USE_ROUTE = 30;

    public function __construct
    (
        protected MultipleRouteStorage $multipleRouteStorage,
    ) {
    }

    public function handle(SomeEvent $event, Closure $next): SomeEvent
    {
        $value = $this->multipleRouteStorage->get($event->getUserId());
        if ($value === 0) {
            $this->multipleRouteStorage->set($event->getUserId());
        }
        if ($value > 0) {
            $this->multipleRouteStorage->incr($event->getUserId());
        }
        if ($value <= self::MAX_USE_ROUTE) {
            return $next($event);
        }
        Log::info('multiple route');
        return $next($event);
    }
}
