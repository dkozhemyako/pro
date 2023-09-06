<?php

namespace App\Console\Commands;

use App\Services\Rabbit\RabbitConsumerService;
use Illuminate\Console\Command;

class RabbitConsumerWord extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbit-consumer-word';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(RabbitConsumerService $service): void
    {
        $service->subscribe();
    }
}
