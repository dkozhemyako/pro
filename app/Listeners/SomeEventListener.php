<?php

namespace App\Listeners;

use App\Events\SomeEvent;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Log;

class SomeEventListener
{

    /**
     * Create the event listener.
     */
    protected const HANDLERS = [
        SingleRouteHandler::class,
        MultipleRouteHandler::class,
    ];

    public function __construct
    (
        protected Pipeline $pipeline,
    ) {
    }

    /**
     * Handle the event.
     */
    public function handle(SomeEvent $event): void
    {
        Log::info('win win');
        $this->pipeline
            ->send($event)
            ->through(self::HANDLERS)
            ->then(function (SomeEvent $event) {
                return $event;
            });
    }
}
