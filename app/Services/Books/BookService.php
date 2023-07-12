<?php

namespace App\Services\Books;

use App\Repositories\Books\BookIndexDTO;
use App\Repositories\Books\BookRepository;
use App\Repositories\Books\BookStoreDTO;
use App\Repositories\Books\Iterators\BookIterator;
use mysql_xdevapi\Collection;

class BookService
{
    public function __construct(
        protected BookRepository $bookRepository,
    )
    {
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

    public function update(BookStoreDTO $data, int $bookId): BookIterator
    {
        $this->bookRepository->updateById($data, $bookId);
        return $this->bookRepository->getById($bookId);
    }

    public function delete(int $bookId): int
    {
        return $this->bookRepository->deleteById($bookId);
    }

    public function index(BookIndexDTO $data): \Illuminate\Support\Collection
    {
        if ($data->getYear() !== null && $data->getLang() === null) {
            return $this->bookRepository->getYear($data);
        }
        if ($data->getYear() === null && $data->getLang() !== null) {
            return $this->bookRepository->getLang($data);
        }
        if ($data->getYear() !== null && $data->getLang() !== null) {
            return $this->bookRepository->getYearLang($data);
        }

        return $this->bookRepository->getDate($data);


    }

}
