<?php

namespace App\Console\Commands;

use App\Services\BookByCommand\BookselectAndUpdateService;
use Illuminate\Console\Command;

class SelectAndUpdateBookCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:select-and-update-book-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(BookselectAndUpdateService $service)
    {
        $service->handle();
    }
}
