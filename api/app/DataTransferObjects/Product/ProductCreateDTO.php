<?php

namespace App\DataTransferObjects\Product;

use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;

class ProductCreateDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly float $price,
        public readonly \DateTimeInterface $dateValidity,
        public readonly UploadedFile $image,
        public readonly int $categoryId
    )
    {
    }

    /**
     * @throws \Exception
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->input('name'),
            $request->input('description'),
            $request->input('price'),
            new \DateTime($request->input('date_validity')),
            $request->file('image'),
            $request->input('price'),
        );
    }

}
