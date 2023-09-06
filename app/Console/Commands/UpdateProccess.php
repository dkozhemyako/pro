<?php

namespace App\Console\Commands;

use App\Services\SuperVisor\ProcessDTO;
use App\Services\SuperVisor\SuperVisorService;
use Illuminate\Console\Command;

class UpdateProccess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-proccess';

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
        $name = $this->ask('Enter the name of the process to update');
        $command = $this->ask('Enter new command for artisan');
        $number = $this->ask('Enter new the number of processes to run');

        $process = new ProcessDTO([
            'name' => $name,
            'command' => 'php /var/www/html/artisan ' . $command,
            'number' => $number,
        ]);

        $hasSection = $service->hasSection($process->getName());
        if ($hasSection === false) {
            $this->info('Process with this name does not exist');
            return;
        }
        $service->updateProcesses($process);
        $this->info('Process successfully updated');
        exec('supervisorctl reread');
        exec('supervisorctl update');
    }
}
