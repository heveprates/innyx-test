<?php

namespace App\Http\Requests;

class UpdateProductRequest extends StoreProductRequest
{
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:200',
            'price' => 'nullable|numeric|min:0',
            'date_validity' => 'nullable|date|after:today',
            'image' => 'nullable|image',
            'category_id' => 'nullable|exists:categories,id'
        ];
    }
}
