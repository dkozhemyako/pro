<?php

namespace App\Http\Controllers\Category;

use App\Exceptions\CategoryStoreExeption;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryDestroyRequest;
use App\Http\Requests\Category\CategoryShowRequest;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\ErrorResource;
use App\Repositories\Categories\CategoryStoreDTO;
use App\Repositories\Categories\CategoryUpdateDTO;
use App\Services\Category\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->getSuccessResponse(
            CategoryResource::collection($this->categoryService->index())
        );
    }

    /**
     * Store a newly created resource in storage.
     * @throws CategoryStoreExeption
     */
    public function store(CategoryStoreRequest $request): JsonResponse|ErrorResource
    {
        $validated = $request->validated();
        $dto = new CategoryStoreDTO(
            $validated['name'],
            now(),
        );

        try {
            $result = $this->categoryService->store($dto);
            return $this->getStoreResponse(
                new CategoryResource($result)
            );
        } catch (CategoryStoreExeption $categoryStoreExeption) {
            return new ErrorResource($categoryStoreExeption);
        }
        /*
        finally {
            var_dump('finally'); // наприклад спосіб сповіщення
        }
        */
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryShowRequest $request, string $id): JsonResponse
    {
        $validated = $request->validated();
        return
            $this->getSuccessResponse(
                new CategoryResource(
                    $this->categoryService->show($validated['id'])
                )
            );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, string $id): JsonResponse
    {
        $validated = $request->validated();
        $dto = new CategoryUpdateDTO(
            $validated['name'],
            now(),
        );
        return
            $this->getSuccessResponse(
                new CategoryResource(
                    $this->categoryService->update($dto, $validated['id'])
                )
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryDestroyRequest $request, string $id): Response
    {
        $validated = $request->validated();
        $this->categoryService->delete($validated['id']);
        return $this->getNoContentResponse();
    }
}
