<?php

namespace App\Services\TelegramBot\Handlers\UpdateHandler\Handlers;

use App\Enums\LangEnum;
use App\Repositories\Books\BookRepository;
use App\Repositories\Books\BookStoreDTO;
use App\Repositories\Books\BookUpdateDTO;
use App\Repositories\Books\Iterators\BookIterator;
use App\Services\TelegramBot\Handlers\CreateBookHandler\CreateBookHandlersInterface;
use App\Services\TelegramBot\Handlers\CreateBookHandler\CreateBookTelegramDTO;
use App\Services\TelegramBot\Handlers\UpdateHandler\UpdateBookHandlersInterface;
use App\Services\TelegramBot\Handlers\UpdateHandler\UpdateBookTelegramDTO;
use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redis;

class RepositoryHandler implements UpdateBookHandlersInterface
{

    public function __construct(
        protected BookRepository $repository,
    ) {
    }

    public function handle(UpdateBookTelegramDTO $updateBookTelegramDTO, Closure $next): UpdateBookTelegramDTO
    {
        $dto = new BookUpdateDTO(
            $updateBookTelegramDTO->getName(),
            $updateBookTelegramDTO->getYear(),
            $updateBookTelegramDTO->getLang(),
            $updateBookTelegramDTO->getPages(),
            Carbon::createFromTimestamp(time()),

        );

        $this->repository->updateById($dto, $updateBookTelegramDTO->getId());
        $book = $this->repository->getById($updateBookTelegramDTO->getId());

        /** @var BookIterator $book */

        $result = 'Updated book:' . PHP_EOL;

        $result .= 'id: ' . $book->getId() . PHP_EOL;
        $result .= 'name: ' . $book->getName() . PHP_EOL;
        $result .= 'pages: ' . $book->getPages() . PHP_EOL;
        $result .= 'lang: ' . $book->getLang() . PHP_EOL;
        $result .= 'year: ' . $book->getYear() . PHP_EOL;
        $result .= PHP_EOL;

        $updateBookTelegramDTO->setMessage($result);

        return $updateBookTelegramDTO;
    }
}
