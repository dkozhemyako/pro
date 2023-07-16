<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Task5 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:task5 {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To complete task number 5';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $age = $this->ask('How old are you??');
        if ($age < 18) {
            if (!$this->confirm('Are you sure you want to continue?')) {
                $this->error('Goodbye');
                return;
            }
        }

        $type = $this->askWithCompletion('Do you want to read or write a file?', ['read', 'write']);
        if ($type === 'read') {
            if (file_exists('/test')) {
                echo file_get_contents('/test');
                return;
            }
            $this->error('The file does not exist');
            return;
        }

        if ($type === 'write') {
            $info['name'] = $this->argument('name');
            $info['gender'] = $this->ask('Enter your gender');
            $info['city'] = $this->ask('In which city do you live?');
            $info['phone'] = $this->ask('Enter a phone number');


            if (!file_put_contents('/test', json_encode($info))) {
                $this->error('An error occurred while writing the file');
                return;
            }

            $this->alert('Success');
            return;
        }

        $this->warn('You did not select any option, start from the beginning');
    }
}
