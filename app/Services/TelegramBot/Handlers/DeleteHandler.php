<?php

namespace App\Services\TelegramBot\Handlers;

use App\Repositories\Books\BookRepository;
use App\Services\TelegramBot\ComandsInterface;

class DeleteHandler implements ComandsInterface
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
            $this->bookRepository->deleteById((int)$arguments);
            return 'Book delete successful';
        }

        return 'Enter Book ID for delete';
    }
}
