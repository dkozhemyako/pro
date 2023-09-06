<?php

namespace App\Console\Commands;

use App\Services\SuperVisor\SuperVisorService;
use Illuminate\Console\Command;

class DelProccess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:del-proccess';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(SuperVisorService $service)
    {
        $name = $this->ask('Enter the name of the process to delete');

        $service->deleteProcess($name);
        $this->info('Delete process success');
    }
}
