<?php

namespace App\Console\Commands;

use App\Services\Proxy\GetMyIpService;
use App\Services\Proxy\WebShareService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class GetMyIp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:ip';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To complete task number 20';

    /**
     * Execute the console command.
     */
    public function handle(GetMyIpService $getMyIpService)
    {
        $this->alert($getMyIpService->handle());
    }
}
