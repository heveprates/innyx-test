<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollectionResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(fn($category) => self::itemToArray($category)),
        ];
    }

    public function paginationInformation(Request $request, array $paginated, array $default)
    {
        return [
            'meta'=> [
                'current_page' => $paginated['current_page'],
                'last_page' => $paginated['last_page'],
                'per_page' => $paginated['per_page'],
                'total' => $paginated['total'],
            ],
        ];
    }

    private static function itemToArray(Category $category): array
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
        ];
    }
}
