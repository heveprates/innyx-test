<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollectionResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(fn(Product $product) => self::itemToArray($product)),
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

    private static function itemToArray(Product $product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'valid' => $product->date_validity->format(\DateTimeInterface::ISO8601),
            'imageUrl' => url($product->image),
        ];
    }
}
