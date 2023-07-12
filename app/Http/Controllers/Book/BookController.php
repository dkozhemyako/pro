<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\BookDestroyRequest;
use App\Http\Requests\Book\BookIndexRequest;
use App\Http\Requests\Book\BookShowRequest;
use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Http\Resources\Book\BookResource;
use App\Repositories\Books\BookIndexDTO;
use App\Repositories\Books\BookStoreDTO;
use App\Services\Books\BookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;


class BookController extends Controller
{
    public function __construct(
        protected BookService $bookService,
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(BookIndexRequest $request): \Illuminate\Support\Collection
    {
        $validated = $request->validated();
        $dto = new BookIndexDTO(
            $validated['startDate'],
            $validated['endDate'],
            $validated,
        );

        return $this->bookService->index($dto);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $dto = new BookStoreDTO(
            $validated['name'],
            $validated['year'],
            $validated['lang'],
            $validated['pages'],
            now(),
            now(),
        );

        return $this->getStoreResponse(
            new BookResource(
                $this->bookService->store($dto)
            )
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(BookShowRequest $request, string $id): JsonResponse
    {
        $validated = $request->validated();
        return
            $this->getSuccessResponse(
                new BookResource(
                    $this->bookService->show($validated['id'])
                )
            );

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookUpdateRequest $request, string $id): JsonResponse
    {
        $validated = $request->validated();
        $dto = new BookStoreDTO(
            $validated['name'],
            $validated['year'],
            $validated['lang'],
            $validated['pages'],
            now(),
            now(),
        );
        return
            $this->getSuccessResponse(
                new BookResource(
                    $this->bookService->update($dto, $validated['id'])
                )
            );

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookDestroyRequest $request, string $id): Response
    {
        $validated = $request->validated();
        $this->bookService->delete($validated['id']);
        return $this->getNoContentResponse();


    }

}
