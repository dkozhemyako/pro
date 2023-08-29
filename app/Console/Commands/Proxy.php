<?php

namespace App\Console\Commands;

use App\Services\Proxy\WebShareService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class Proxy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:proxy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To complete task number 20';

    /**
     * Execute the console command.
     */
    public function handle(WebShareService $webShareService)
    {
        $webShareService->getProxy();
    }
}
