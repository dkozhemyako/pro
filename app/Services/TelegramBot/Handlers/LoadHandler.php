<?php

namespace App\Services\TelegramBot\Handlers;

use App\Repositories\Books\BookRepository;
use App\Repositories\Books\Iterators\BookIterator;
use App\Services\TelegramBot\ComandsInterface;

class LoadHandler implements ComandsInterface
{
    public function __construct(
        protected BookRepository $bookRepository
    ) {
    }

    /**
     * @throws \Exception
     */
    public function handle(string $arguments, int $senderId): string
    {
        $result = '';
        $books = $this->bookRepository->getByDataTelegram((int)$arguments);
        /** @var BookIterator $book */
        foreach ($books as $book) {
            $result .= 'id: ' . $book->getId() . PHP_EOL;
            $result .= 'name: ' . $book->getName() . PHP_EOL;
            $result .= 'pages: ' . $book->getPages() . PHP_EOL;
            $result .= 'lang: ' . $book->getLang() . PHP_EOL;
            $result .= 'year: ' . $book->getYear() . PHP_EOL;
            $result .= PHP_EOL;
        }
        $result .= 'Enter last ID for load next 5 books';

        return $result;
    }
}
