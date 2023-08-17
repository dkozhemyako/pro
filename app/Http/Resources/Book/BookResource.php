<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\Author\AuthorResource;
use App\Http\Resources\Category\CategoryResource;
use App\Repositories\Authors\Iterators\AuthorsIterator;
use App\Repositories\Books\Iterators\BookIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var BookIterator $resource */
        $resource = $this->resource;
        return [
            'id' => $resource->getId(),
            'name' => $resource->getName(),
            'year' => $resource->getYear(),
            'lang' => $resource->getLang(),
            'pages' => $resource->getPages(),
            'category' => new CategoryResource($resource->getCategory()),
            'authors' => AuthorResource::collection($resource->getAuthors()),

        ];
    }
}
