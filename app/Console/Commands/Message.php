<?php

namespace App\Console\Commands;


use App\Enums\LangEnum;
use App\Services\Rabbit\Messages\BookStoreMessageDTO;
use Illuminate\Console\Command;

class Message extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:start';

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
        $message = new BookStoreMessageDTO(
            (object)[
                'name' => 'Name',
                'year' => '2023',
                'lang' => LangEnum::EN->value,
                'pages' => 123,
                'createdAt' => now(),
                'categoryId' => 1,
            ]

        );

        $decoded = json_encode($message);
        $this->info($decoded);

        //subscribe

        $newMassage = new BookStoreMessageDTO(json_decode($decoded));
        var_dump($newMassage);
    }
}
