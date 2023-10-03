<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\Author\AuthorResource;
use App\Http\Resources\Category\CategoryResource;
use App\Repositories\Authors\Iterators\AuthorsIterator;
use App\Repositories\Books\Iterators\BookIterator;
use App\Repositories\Books\Iterators\BookOldIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookOldResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     * @throws \Exception
     */
    public function toArray(Request $request): array
    {
        /** @var BookOldIterator $resource */
        $resource = $this->resource;
        return [
            'id' => $resource->getId(),
            'name' => $resource->getName(),
            'year' => $resource->getYear(),
            'lang' => $resource->getLang(),
            'pages' => $resource->getPages(),
            'category' => new CategoryResource($resource->getCategory()),

        ];
    }
}
