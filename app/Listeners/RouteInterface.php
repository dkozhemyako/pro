<?php

namespace App\Listeners;

use App\Events\SomeEvent;
use Closure;

interface RouteInterface
{
    public function handle(SomeEvent $event, Closure $next): SomeEvent;
}
