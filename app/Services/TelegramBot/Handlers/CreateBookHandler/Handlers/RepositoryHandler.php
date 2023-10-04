<?php

namespace App\Services\TelegramBot\Handlers\CreateBookHandler\Handlers;

use App\Enums\LangEnum;
use App\Repositories\Books\BookRepository;
use App\Repositories\Books\BookStoreDTO;
use App\Repositories\Books\Iterators\BookIterator;
use App\Services\TelegramBot\Handlers\CreateBookHandler\CreateBookHandlersInterface;
use App\Services\TelegramBot\Handlers\CreateBookHandler\CreateBookTelegramDTO;
use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redis;

class RepositoryHandler implements CreateBookHandlersInterface
{

    public function __construct(
        protected BookRepository $repository,
    ) {
    }

    public function handle(CreateBookTelegramDTO $createBookTelegramDTO, Closure $next): CreateBookTelegramDTO
    {
        $dto = new BookStoreDTO(
            $createBookTelegramDTO->getName(),
            $createBookTelegramDTO->getYear(),
            $createBookTelegramDTO->getLang(),
            $createBookTelegramDTO->getPages(),
            Carbon::createFromTimestamp(time()),
            $createBookTelegramDTO->getCategoryId(),
        );

        $bookId = $this->repository->store($dto);
        $book = $this->repository->getById($bookId);

        /** @var BookIterator $book */

        $result = 'Created book:' . PHP_EOL;

        $result .= 'id: ' . $book->getId() . PHP_EOL;
        $result .= 'name: ' . $book->getName() . PHP_EOL;
        $result .= 'pages: ' . $book->getPages() . PHP_EOL;
        $result .= 'lang: ' . $book->getLang() . PHP_EOL;
        $result .= 'year: ' . $book->getYear() . PHP_EOL;
        $result .= PHP_EOL;

        $createBookTelegramDTO->setMessage($result);

        return $createBookTelegramDTO;
    }
}
