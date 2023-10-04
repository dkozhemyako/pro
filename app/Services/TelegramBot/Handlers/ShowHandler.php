<?php

namespace App\Services\TelegramBot\Handlers;

use App\Repositories\Books\BookRepository;
use App\Services\TelegramBot\ComandsInterface;


class ShowHandler implements ComandsInterface
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
        if ((int)$arguments != 0) {
            $oldBook = $this->bookRepository->getById((int)$arguments);
        } else {
            $oldBook = $this->bookRepository->getById(1);
        }

        $result = 'id:' . $oldBook->getId() . PHP_EOL;
        $result .= 'name:' . $oldBook->getName() . PHP_EOL;
        $result .= 'pages:' . $oldBook->getPages() . PHP_EOL;
        $result .= 'lang:' . $oldBook->getLang() . PHP_EOL;
        $result .= 'year:' . $oldBook->getYear() . PHP_EOL;
        $result .= PHP_EOL;

        $result .= 'Enter book ID for show';

        return $result;
    }
}
