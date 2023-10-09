<?php

namespace App\Console\Commands;

use App\Enums\MessengerEnum;
use App\Services\Messenger\MessengerFactory;
use App\Services\Messenger\SlackMessenger\SlackMessengerService;
use App\Services\Messenger\TelegramMessenger\TelegramMessengerService;
use App\Services\Proxy\GetMyIpService;
use App\Services\Proxy\WebShareService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class MessengerTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:msg';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To complete task number 20';

    /**
     * Execute the console command.
     */
    public function handle(MessengerFactory $messengerService)
    {
        $messengerService->handle(MessengerEnum::SLACK)->send('SlackMessengerService');
        $messengerService->handle(MessengerEnum::TELEGRAM)->send('TelegramMessengerService');

        //send all
        foreach (MessengerEnum::cases() as $messenger){
            $messengerService->handle($messenger)->send('send from ' . $messenger->name);
        }
    }
}
