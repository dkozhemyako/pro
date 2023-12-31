<?php

namespace App\Services\Books;

use App\Repositories\Books\BookIndexDTO;
use App\Repositories\Books\BookRepository;
use App\Repositories\Books\BookStoreDTO;
use App\Repositories\Books\BookUpdateDTO;
use App\Repositories\Books\Iterators\BookIterator;
use App\Repositories\Books\Iterators\BookOldIterator;
use App\Repositories\Books\Iterators\BooksIterator;
use Illuminate\Support\Collection;

class BookService
{
    public function __construct(
        protected BookRepository $bookRepository,
    ) {
    }


    public function store(BookStoreDTO $data): BookOldIterator
    {
        $bookId = $this->bookRepository->store($data);
        return $this->bookRepository->getById($bookId);
    }

    public function show(int $bookId): BookOldIterator
    {
        return $this->bookRepository->getById($bookId);
    }

    public function update(BookUpdateDTO $data, int $bookId): BookOldIterator
    {
        $this->bookRepository->updateById($data, $bookId);
        return $this->bookRepository->getById($bookId);
    }

    public function delete(int $bookId): int
    {
        return $this->bookRepository->deleteById($bookId);
    }


    public function index(BookIndexDTO $data): Collection
    {
        if ($data->getYear() !== null && $data->getLang() === null) {
            return $this->bookRepository->getByYear($data);
        }
        if ($data->getYear() === null && $data->getLang() !== null) {
            return $this->bookRepository->getByLang($data);
        }
        if ($data->getYear() !== null && $data->getLang() !== null) {
            return $this->bookRepository->getByYearLang($data);
        }

        return $this->bookRepository->getByData($data);
    }

    /**
     * @throws \Exception
     */
    public function indexIterator(BookIndexDTO $data): BooksIterator
    {
        return $this->bookRepository->getByDataIterator($data);
    }

    public function indexModel(BookIndexDTO $data): Collection
    {
        return $this->bookRepository->getByDataModel($data);
    }

}
