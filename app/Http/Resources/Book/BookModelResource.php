<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\Category\CategoryResource;
use App\Models\Book;
use App\Repositories\Books\Iterators\BookIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookModelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Book $resource */
        $resource = $this->resource;
        return [
            'id' => $resource->id,
            'name' => $resource->name,
            'year' => $resource->year,
            'lang' => $resource->lang,
            'pages' => $resource->pages,
            'category' => $resource->category,
            'authors' => $resource->authors,
        ];
    }
}
