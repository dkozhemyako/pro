<?php

namespace App\Repositories\Books;

use App\Repositories\Books\Iterators\BookIterator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BookRepository
{
    public function store(BookStoreDTO $data): int
    {
        return DB::table('books')
            ->insertGetId([
                'name' => $data->getName(),
                'year' => $data->getYear(),
                'lang' => $data->getLang(),
                'pages' => $data->getPages(),
                'created_at' => $data->getCreatedAt(),
            ]);
    }

    public function getById(int $id): BookIterator
    {
        return new BookIterator(
            DB::table('books')
                ->where('id', '=', $id)
                ->first()
        );
    }

    public function updateById(BookStoreDTO $data, int $id): int
    {
        return DB::table('books')
            ->where('id', '=', $id)
            ->update([
                'name' => $data->getName(),
                'year' => $data->getYear(),
                'lang' => $data->getLang(),
                'pages' => $data->getPages(),
                'updated_at' => $data->getUpdatedAt()
            ]);

    }

    public function deleteById(int $bookId): int
    {
        return DB::table('books')
            ->delete($bookId);
    }

    public function getDate(BookIndexDTO $data): Collection
    {
        return collect(
            DB::table('books')
                ->whereBetween('created_at', [$data->getStartDate(), $data->getEndDate()])
                ->get()

        );
    }

    public function getYear(BookIndexDTO $data): Collection
    {
        return collect(
            DB::table('books')
                ->whereBetween('created_at', [$data->getStartDate(), $data->getEndDate()])
                ->where('year', '=', $data->getYear())
                ->get()

        );
    }

    public function getLang(BookIndexDTO $data): Collection
    {
        return collect(
            DB::table('books')
                ->where('lang', '=', $data->getLang())
                ->whereBetween('created_at', [$data->getStartDate(), $data->getEndDate()])
                ->get()

        );
    }

    public function getYearLang(BookIndexDTO $data): Collection
    {
        return collect(
            DB::table('books')
                ->where('lang', '=', $data->getLang())
                ->where('lang', '=', $data->getLang())
                ->whereBetween('created_at', [$data->getStartDate(), $data->getEndDate()])
                ->get()
        );
    }
}
