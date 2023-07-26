<?php

namespace App\Services\Books;

use App\Repositories\Books\BookIndexDTO;
use App\Repositories\Books\BookRepository;
use App\Repositories\Books\BookStoreDTO;
use App\Repositories\Books\BookUpdateDTO;
use App\Repositories\Books\Iterators\BookIterator;
use Illuminate\Support\Collection;

class BookService
{
    public function __construct(
        protected BookRepository $bookRepository,
    ) {
    }


    public function store(BookStoreDTO $data): BookIterator
    {
        $bookId = $this->bookRepository->store($data);
        return $this->bookRepository->getById($bookId);
    }

    public function show(int $bookId): BookIterator
    {
        return $this->bookRepository->getById($bookId);
    }

    public function update(BookUpdateDTO $data, int $bookId): BookIterator
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

}
