<?php

namespace App\Console\Commands;


use App\Services\Singletone\LoggerLaravel;
use App\Services\Singletone\LoggerPHP;
use Illuminate\Console\Command;

class Singeltone extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'singleton:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To complete task number 24';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $logger = LoggerPHP::getInstance();
        $logger->logMessage('Msg1');
        $logger->logMessage('Msg2');

        $logger2 = LoggerPHP::getInstance();
        $logger2->logMessage('Msg3');

        $this->info($logger->getLog());

        /* $logger3 = new LoggerPHP();  for example,test */
    }
}
