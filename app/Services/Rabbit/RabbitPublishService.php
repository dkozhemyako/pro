<?php

namespace App\Services\Rabbit;

use App\Http\Resources\Book\BookResource;
use App\Repositories\Books\BookIndexDTO;
use App\Services\Books\BookService;
use Bschmitt\Amqp\Facades\Amqp;
use phpseclib3\Crypt\Random;

class RabbitPublishService
{
    public const QUEUE_NAME = 'book_create';
    public const QUEUE_2ND_NAME = 'get_word_result';

    public function __construct(
        protected BookService $bookService,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function handle(): void
    {
        $dto = new BookIndexDTO('2022-01-01', '2024-01-01', []);
        $data = $this->bookService->indexIterator($dto);

        $books = BookResource::collection($data->getIterator()->getArrayCopy());
        foreach ($books as $book) {
            Amqp::publish(self::QUEUE_NAME, json_encode($book), [
                'queue' => self::QUEUE_NAME
            ]);
        }
    }

    public function publish(): void
    {
        $word = fake()->word;

        Amqp::publish(self::QUEUE_2ND_NAME, $word, [
            'queue' => self::QUEUE_2ND_NAME
        ]);
    }
}
