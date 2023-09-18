<?php

namespace App\Console\Commands;

use App\Services\Proxy\CheckTimeService;
use App\Services\Rabbit\RabbitPublishService;
use Illuminate\Console\Command;


class RabbitPublishBook extends Command
{
    private const EXEC_TIME = 300;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbit-publish-book';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * @throws \Exception
     */
    public function handle(RabbitPublishService $service)
    {
        $timeService = new CheckTimeService();

        for ($timeService->setStartTime(); $timeService->getDifTime() < self::EXEC_TIME; $timeService->setEndTime()) {
            $service->handle();
        }
    }
}
