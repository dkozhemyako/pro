<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryDestroyRequest;
use App\Http\Requests\Category\CategoryShowRequest;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Repositories\Categories\CategoryStoreDTO;
use App\Repositories\Categories\CategoryUpdateDTO;
use App\Services\Category\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

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
            CategoryResource::collection($this->categoryService->index()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $dto = new CategoryStoreDTO(
            $validated['name'],
            now(),
        );

        return $this->getStoreResponse(
            new CategoryResource(
                $this->categoryService->store($dto)
            )
        );
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
