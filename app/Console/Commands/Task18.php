<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class Task18 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:redis {expire}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To complete task number 18';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $key = $this->ask('Enter key for redis');
        $value = $this->ask('Enter value, int please');
        if (strlen($key) <= 0 || is_numeric($value) === false) {
            $this->error('data is not valid');
        }
        Redis::set($key, $value, 'EX', $this->argument('expire'));
        $this->info($key . ' created for ' . $this->argument('expire') . 'sec');

        $action = $this->choice(
            'What do we do next??',
            ['Read', 'Delete', 'Increment', 'Decrement'],
            'Read'
        );

        switch ($action) {
            case 'Read':
                echo Redis::get($key);
                $this->alert('Read succeed');
                break;
            case 'Delete':
                Redis::delete($key);
                $this->alert('Delete succeed');
                break;
            case 'Increment':
                echo Redis::incr($key);
                $this->alert('Increment succeed');
                break;
            case 'Decrement':
                echo Redis::decr($key);
                $this->alert('Decrement succeed');
                break;
        }
    }
}
