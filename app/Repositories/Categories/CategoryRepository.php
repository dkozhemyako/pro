<?php

namespace App\Repositories\Categories;

use App\Repositories\Categories\Iterators\CategoryIterator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;


class CategoryRepository
{
    public function store(CategoryStoreDTO $data): int
    {
        return DB::table('categories')
            ->insertGetId([
                'name' => $data->getName(),
            ]);
    }

    public function getById(int $id): CategoryIterator
    {
        return new CategoryIterator(
            DB::table('categories')
                ->where('id', '=', $id)
                ->first()
        );
    }

    public function getByName(string $name): bool
    {
        return
            DB::table('categories')
                ->where('name', '=', $name)
                ->exists();
    }

    public function updateById(CategoryUpdateDTO $data, int $id): void
    {
        DB::table('categories')
            ->where('id', '=', $id)
            ->update([
                'name' => $data->getName(),
            ]);
    }

    public function deleteById(int $categoryId): int
    {
        return DB::table('categories')
            ->delete($categoryId);
    }

    public function getAllDate(): Collection
    {
        $result = DB::table('categories')
            ->select([
                'id',
                'name',
            ])
            ->get();

        return $result->map(function ($item) {
            return new CategoryIterator($item);
        });
    }

}
