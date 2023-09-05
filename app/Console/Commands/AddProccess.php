<?php

namespace App\Console\Commands;

use App\Services\SuperVisor\ProcessDTO;
use App\Services\SuperVisor\SuperVisorService;
use Illuminate\Console\Command;

class AddProccess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-proccess';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Task 22';

    /**
     * Execute the console command.
     */
    public function handle(SuperVisorService $service)
    {
        $name = $this->ask('Enter new proccess name');
        $command = $this->ask('Enter command for artisan');
        $number = $this->ask('Enter the number of processes to run');

        $process = new ProcessDTO([
            'name' => $name,
            'command' => 'php /var/www/html/artisan ' . $command,
            'number' => $number,
        ]);
        $hasSection = $service->hasSection($process->getName());
        if ($hasSection === false) {
            $service->addProcessesConfig($process);
            $this->info('Created new process success');
            exec('supervisorctl reread');
            exec('supervisorctl update');
        }
    }
}
