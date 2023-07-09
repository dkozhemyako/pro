<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\BookDestroyRequest;
use App\Http\Requests\Book\BookShowRequest;
use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Http\Resources\Book\BookResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return BookResource::collection([
            (object)[
                'id' => '9',
                'name' => 'Store',
                'author' => 'AuthorTest',
                'year' => 2023,
                'countPages' => 10,
            ],
            (object)[
                'id' => '99',
                'name' => 'Show',
                'author' => 'AuthorTest',
                'year' => 2023,
                'countPages' => 10,
            ],
            (object)[
                'id' => '999',
                'name' => 'Update',
                'author' => 'AuthorTest',
                'year' => 2023,
                'countPages' => 10,
            ]
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookStoreRequest $request): BookResource
    {
        $request->validated();

        return new BookResource((object)[
            'id' => '9',
            'name' => 'Store',
            'author' => 'AuthorTest',
            'year' => 2023,
            'countPages' => 10,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(BookShowRequest $request, string $id): BookResource
    {
        $request->validated();

        return new BookResource((object)[
            'id' => '99',
            'name' => 'Show',
            'author' => 'AuthorTest',
            'year' => 2023,
            'countPages' => 10,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookUpdateRequest $request, string $id): BookResource
    {
        $request->validated();
        return new BookResource((object)[
            'id' => '999',
            'name' => 'Update',
            'author' => 'AuthorTest',
            'year' => 2023,
            'countPages' => 10,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookDestroyRequest $request, string $id): void
    {
        $request->validated();
    }
}
