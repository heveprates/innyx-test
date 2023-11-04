<?php

namespace App\DataTransferObjects\Product;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ProductUpdateDTO
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $description = null,
        public readonly ?float $price = null,
        public readonly ?\DateTimeInterface $dateValidity = null,
        public readonly ?UploadedFile $image = null,
        public readonly ?int $categoryId = null,
    ) {
    }

    /**
     * @throws \Exception
     */
    public static function fromRequest(Request $request): self
    {
        $name = null;
        if ($request->has('name')) {
            $name = $request->input('name');
        }
        $description = null;
        if ($request->has('description')) {
            $description = $request->input('description');
        }
        $price = null;
        if ($request->has('price')) {
            $price = $request->input('price');
        }
        $dateValidity = null;
        if ($request->has('date_validity')) {
            $dateValidity = new \DateTime($request->input('date_validity'));
        }
        $image = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
        }
        $categoryId = null;
        if ($request->has('category_id')) {
            $categoryId = $request->input('category_id');
        }
        return new self(
            $name,
            $description,
            $price,
            $dateValidity,
            $image,
            $categoryId,
        );
    }
}
