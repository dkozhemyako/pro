<?php

namespace App\Console\Commands;

use App\Services\SuperVisor\SuperVisorService;
use Illuminate\Console\Command;
use Supervisor\Supervisor;

class GetAllSupervisorProc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-all-supervisor-proc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Task22';

    /**
     * Execute the console command.
     */
    public function handle(SuperVisorService $service)
    {
        $statusAll = [];
        exec('supervisorctl status', $statusAll);
        foreach ($statusAll as $status) {
            echo $status . "\n";
        }
    }
}
