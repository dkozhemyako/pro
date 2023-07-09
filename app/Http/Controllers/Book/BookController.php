<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\BookShowRequest;
use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Resources\Book\BookResource;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookStoreRequest $request): BookResource
    {
        $request->validated();

        return new BookResource((object)[
            'id' => '9',
            'name' => 'Test',
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
            'name' => 'Test',
            'author' => 'AuthorTest',
            'year' => 2023,
            'countPages' => 10,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
