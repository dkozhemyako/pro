<?php

namespace App\Services\Rabbit;

use App\Console\Commands\FillOldBookDataCommand;
use App\Enums\LangEnum;
use App\Repositories\Books\BookReplaceStoreDTO;
use App\Repositories\Books\BookRepository;
use Bschmitt\Amqp\Facades\Amqp;
use Illuminate\Support\Carbon;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitBookReplaceConsumerService
{
    public function __construct(
        protected BookRepository $bookRepository,

    ) {
    }

    public function handle(): void
    {
        Amqp::consume(FillOldBookDataCommand::QUEUE_NAME, function (AMQPMessage $message) {
            $data = json_decode($message->getBody(), true);
            $bookDTO = new BookReplaceStoreDTO
                (
                $data['id'],
                $data['name'],
                $data['year'],
                LangEnum::from($data['lang']),
                $data['pages'],
                Carbon::now(),
                $data['category']['id'],
            );

            $this->bookRepository->storeReplaceBook($bookDTO);

            $message->ack();
        });
    }

}
