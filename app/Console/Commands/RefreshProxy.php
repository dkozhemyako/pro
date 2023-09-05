<?php

namespace App\Console\Commands;

use App\Services\Proxy\WebShareService;
use Illuminate\Console\Command;

class RefreshProxy extends Command
{
    public function __construct(

        protected WebShareService $webShareService,
    ) {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh-proxy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->webShareService->refreshProxy();
    }
}
