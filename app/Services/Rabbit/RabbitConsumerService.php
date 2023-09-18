<?php

namespace App\Services\Rabbit;

use App\Enums\LangEnum;
use App\Repositories\Books\AuthorBookCreateDTO;
use App\Repositories\Books\BookRepository;
use App\Repositories\Books\BookStoreDTO;
use App\Repositories\Word\WordDTO;
use App\Repositories\Word\WordRepository;
use App\Services\Proxy\GetMyIpService;
use App\Services\Proxy\ProxyStorage;
use Bschmitt\Amqp\Facades\Amqp;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitConsumerService
{
    public function __construct(
        protected BookRepository $bookRepository,
        protected Client $client,
        protected WordRepository $wordRepository,
        protected ProxyStorage $proxyStorage,
        protected GetMyIpService $getMyIpService,
    ) {
    }

    public function handle(): void
    {
        Amqp::consume(RabbitPublishService::QUEUE_NAME, function (AMQPMessage $message) {
            $data = json_decode($message->getBody(), true);
            $bookDTO = new BookStoreDTO(
                $data['name'],
                $data['year'],
                LangEnum::from($data['lang']),
                $data['pages'],
                Carbon::now(),
                $data['category']['id'],
            );

            $bookId = $this->bookRepository->store($bookDTO);

            foreach ($data['authors'] as $author) {
                $bookAuthorDTO = new AuthorBookCreateDTO(
                    $author['id'],
                    $bookId,
                );

                $this->bookRepository->storeBookAuthor($bookAuthorDTO);
            }
            $message->ack();
        });
    }

    public function subscribe()
    {
        Amqp::consume(RabbitPublishService::QUEUE_2ND_NAME, function (AMQPMessage $message) {
            $word = $message->getBody();

            $proxy = $this->proxyStorage->lpop();
            $result = $this->client->
            get(
                'https://serpapi.com/search',
                [
                    'query' => [
                        'engine' => 'duckduckgo',
                        'q' => $word,
                        'k1' => 'ua-uk',
                        'api_key' => config('serp.api_key')
                    ],
                    'proxy' => $proxy->getProxyUrl(),
                ]
            );

            $this->proxyStorage->rpush($proxy);

            $dto = new WordDTO(
                $word,
                $result->getBody()->getContents(),
            );

            $this->wordRepository->store($dto);
            Log::info($this->getMyIpService->handle());

            $message->ack();
        });
    }
}
