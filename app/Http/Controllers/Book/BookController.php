<?php

namespace App\Http\Controllers\Book;

use App\Enums\LangEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Book\BookDestroyRequest;
use App\Http\Requests\Book\BookIndexRequest;
use App\Http\Requests\Book\BookShowRequest;
use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Http\Resources\Book\BookModelResource;
use App\Http\Resources\Book\BookOldResource;
use App\Http\Resources\Book\BookResource;
use App\Repositories\Books\BookIndexDTO;
use App\Repositories\Books\BookStoreDTO;
use App\Repositories\Books\BookUpdateDTO;
use App\Services\Books\BookService;
use App\Services\Books\BookServiceIteratorCache;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;


class BookController extends Controller
{
    public function __construct(
        protected BookService $bookService,
        protected BookServiceIteratorCache $bookServiceIteratorCache,
    ) {
    }

    /**
     * Display a listing of the resource.
     * @throws \Exception
     */

    public function indexModel(BookIndexRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $dto = new BookIndexDTO(
            $validated['startDate'],
            $validated['endDate'],
            $validated,
        );

        return $this->getSuccessResponse(
            BookModelResource::collection($this->bookService->indexModel($dto))
        );
    }

    /**
     * @throws \Exception
     */
    public function indexIterator(BookIndexRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $dto = new BookIndexDTO(
            $validated['startDate'],
            $validated['endDate'],
            $validated,
        );
        $data = $this->bookService->indexIterator($dto);
        return $this->getSuccessResponse(
            BookResource::collection($data->getIterator()->getArrayCopy())
        );
    }

    /**
     * @throws \Exception
     */
    public function indexIteratorCache(BookIndexRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $dto = new BookIndexDTO(
            $validated['startDate'],
            $validated['endDate'],
            $validated,
        );
        $data = $this->bookServiceIteratorCache->indexIteratorNoCache($dto);
        return $this->getSuccessResponse(
            BookResource::collection($data->getIterator()->getArrayCopy())
        );
    }

    public function index(BookIndexRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $dto = new BookIndexDTO(
            $validated['startDate'],
            $validated['endDate'],
            $validated,
        );

        return $this->getSuccessResponse(
            BookOldResource::collection($this->bookService->index($dto))
        );
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
            LangEnum::from($validated['lang']),
            $validated['pages'],
            now(),
            $validated['categoryId'],
        );

        return $this->getStoreResponse(
            new BookOldResource(
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
        $dto = new BookUpdateDTO(
            $validated['name'],
            $validated['year'],
            LangEnum::from($validated['lang']),
            $validated['pages'],
            now(),
        );
        return
            $this->getSuccessResponse(
                new BookOldResource(
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
