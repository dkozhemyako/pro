<?php

namespace App\Services\BookByCommand;

use App\Enums\LangEnum;
use App\Repositories\Books\BookStoreDTO;
use App\Services\Books\BookService;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;

class BookCreateService
{
    public function __construct(
        protected Client $client,
        protected BookService $bookService,
    ){}

    public function handle(){

        while(true){
            $dto = new BookStoreDTO(
                'NewBook' . rand(1, 100000),
                '2023',
                LangEnum::from('ua'),
                rand(1, 1000),
                Carbon::createFromTimestamp(time()),
                2,
            );
            $response = $this->bookService->store($dto);

            /*
            $this->client->post('http://192.168.56.56:86/api/books', [
                'json' => [
                    'name' => 'NewBook' . rand(1, 100000),
                    'year' => '2023',
                    'lang'=> 'ua',
                    'pages'=> '123',
                    'categoryId'=> '2'
                ],
            ]);
            */
            echo 'created ' . $response->getId() . ' ' . date('c') .  PHP_EOL;
        }

    }
}
