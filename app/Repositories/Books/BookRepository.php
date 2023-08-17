<?php

namespace App\Repositories\Books;

use App\Models\Book;
use App\Repositories\Books\Iterators\BookIterator;
use App\Repositories\Books\Iterators\BooksIterator;
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
                'category_id' => $data->getCategoryId(),
            ]);
    }

    public function getById(int $id): BookIterator
    {
        return new BookIterator(
            DB::table('books')
                ->select([
                    'books.id',
                    'books.name',
                    'year',
                    'lang',
                    'pages',
                    'category_id',
                    'categories.name as category_name',
                ])
                ->join('categories', 'categories.id', '=', 'books.category_id')
                ->where('books.id', '=', $id)
                ->first()
        );
    }

    public function updateById(BookUpdateDTO $data, int $id): void
    {
        DB::table('books')
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

    public function getByData(BookIndexDTO $data): Collection
    {
        $result = DB::table('books')
            ->select([
                'books.id',
                'books.name',
                'year',
                'lang',
                'pages',
                'category_id',
                'categories.name as category_name',
            ])
            //->forceIndex('PRIMARY, books_created_at_index')
            ->join('categories', 'categories.id', '=', 'books.category_id')
            ->orderBy('books.id')
            ->limit('1000')
            ->where('books.id', '>', $data->getLastId())
            ->whereBetween('books.created_at', [$data->getStartDate(), $data->getEndDate()])
            ->get();

        return $result->map(function ($item) {
            return new BookIterator($item);
        });
    }

    public function getByDataIterator(BookIndexDTO $data): BooksIterator
    {
        $result = DB::table('books')
            ->select([
                'books.id',
                'books.name',
                'year',
                'lang',
                'pages',
                'category_id',
                'categories.name as category_name',
                'authors.id as author_id',
                'authors.name as author_name',

            ])
            //->forceIndex('PRIMARY, books_created_at_index')
            ->join('categories', 'categories.id', '=', 'books.category_id')
            ->join('author_book', 'books.id', '=', 'author_book.book_id')
            ->join('authors', 'author_book.author_id', '=', 'authors.id')
            ->orderBy('books.id')
            ->limit('1000')
            ->where('books.id', '>', $data->getLastId())
            ->whereBetween('books.created_at', [$data->getStartDate(), $data->getEndDate()])
            ->get();

        return new BooksIterator($result);
    }

    public function getByDataModel(BookIndexDTO $data): Collection
    {
        return Book::query()
            ->with('category') // ['category', 'authors']
            ->orderBy('books.id')
            ->limit('1000')
            ->where('books.id', '>', $data->getLastId())
            ->whereBetween('books.created_at', [$data->getStartDate(), $data->getEndDate()])
            ->get();
    }

    public function getByYear(BookIndexDTO $data): Collection
    {
        $result = DB::table('books')
            ->select([
                'books.id',
                'books.name',
                'year',
                'lang',
                'pages',
                'category_id',
                'categories.name as category_name',
            ])
            ->forceIndex('books_created_at_index, books_year_index')
            ->join('categories', 'categories.id', '=', 'books.category_id')
            ->orderBy('books.id')
            ->limit('10')
            ->where('books.id', '>', $data->getLastId())
            ->where('year', '=', $data->getYear())
            ->whereBetween('books.created_at', [$data->getStartDate(), $data->getEndDate()])
            ->get();

        return $result->map(function ($item) {
            return new BookIterator($item);
        });
    }

    public function getByLang(BookIndexDTO $data): Collection
    {
        $result = DB::table('books')
            ->select([
                'books.id',
                'books.name',
                'year',
                'lang',
                'pages',
                'category_id',
                'categories.name as category_name',
            ])
            ->forceIndex('books_created_at_index, books_lang_index')
            ->join('categories', 'categories.id', '=', 'books.category_id')
            ->orderBy('books.id')
            ->limit('10')
            ->where('books.id', '>', $data->getLastId())
            ->where('lang', '=', $data->getLang())
            ->whereBetween('books.created_at', [$data->getStartDate(), $data->getEndDate()])
            ->get();

        return $result->map(function ($item) {
            return new BookIterator($item);
        });
    }

    public function getByYearLang(BookIndexDTO $data): Collection
    {
        $result = DB::table('books')
            ->select([
                'books.id',
                'books.name',
                'year',
                'lang',
                'pages',
                'category_id',
                'categories.name as category_name',
            ])
            ->forceIndex('PRIMARY, books_created_at_index, books_year_index, books_lang_index')
            ->join('categories', 'categories.id', '=', 'books.category_id')
            ->orderBy('books.id')
            ->limit('10')
            ->where('books.id', '>', $data->getLastId())
            ->where('lang', '=', $data->getLang())
            ->where('year', '=', $data->getYear())
            ->whereBetween('books.created_at', [$data->getStartDate(), $data->getEndDate()])
            ->get();

        return $result->map(function ($item) {
            return new BookIterator($item);
        });
    }
}
