<?php

namespace App\Services\BookByCommand;

use App\Enums\LangEnum;
use App\Repositories\Books\BookIndexDTO;
use App\Repositories\Books\BookRepository;
use App\Repositories\Books\BookUpdateDTO;
use App\Repositories\Books\Iterators\BookOldIterator;
use App\Repositories\Books\Iterators\BooksIterator;
use App\Services\Books\BookService;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;

class BookselectAndUpdateService
{
    public function __construct(
        protected Client $client,
        protected BookRepository $bookService,
    ){}

    public function handle(){

        $id = 1;
        while(true){

            $dto = new BookIndexDTO(
                '2022-01-01',
                '2024-01-01',
                [
                    'year' => 2023,
                    'lastId' => $id,
                ],
            );
            $books = $this->bookService->getByYear($dto);

            echo 'select' . PHP_EOL;

            /** @var BookOldIterator $book*/
            foreach ($books as $book){
                $dto = new BookUpdateDTO(
                    $book->getName() . rand(1, 100),
                    $book->getYear(),
                    LangEnum::from($book->getLang()),
                    $book->getPages() + rand(1, 1000),
                    Carbon::createFromTimestamp(time()),
                );
                $this->bookService->updateById($dto,  $book->getId());
                $id = $book->getId();
                echo 'update ' . $id . PHP_EOL;
            }
        }
    }
}

/*
$response = $this->client->get('http://192.168.56.56:86/api/books?startDate=2022-01-01&endDate=2024-01-01&year=2023', [
    'json' => [
        'lastId' => $id,
    ],
]);
$content = $response->getBody()->getContents();
$books = json_decode($content);
*/
