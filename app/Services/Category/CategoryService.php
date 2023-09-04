<?php

namespace App\Services\Category;

use App\Console\Commands\PublishDTO;
use App\Repositories\Categories\CategoryRepository;
use App\Repositories\Categories\CategoryStoreDTO;
use App\Repositories\Categories\CategoryUpdateDTO;
use App\Repositories\Categories\Iterators\CategoryIterator;
use Illuminate\Support\Facades\Redis;


class CategoryService
{
    public function __construct(
        protected CategoryRepository $categoryRepository,
    ) {
    }


    public function store(CategoryStoreDTO $data): CategoryIterator
    {
        $categoryId = $this->categoryRepository->store($data);

        $category = $this->categoryRepository->getById($categoryId);
        $publishDTO = new PublishDTO($category->getId(), $category->getName());
        Redis::publish('test-channel', json_encode($publishDTO));
        return $category;
    }

    public function show(int $categoryId): CategoryIterator
    {
        return $this->categoryRepository->getById($categoryId);
    }

    public function update(CategoryUpdateDTO $data, int $categoryId): CategoryIterator
    {
        $this->categoryRepository->updateById($data, $categoryId);
        return $this->categoryRepository->getById($categoryId);
    }

    public function delete(int $categoryId): int
    {
        return $this->categoryRepository->deleteById($categoryId);
    }

    public function index(): \Illuminate\Support\Collection
    {
        return $this->categoryRepository->getAllDate();
    }

}
