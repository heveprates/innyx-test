<?php

namespace App\DataTransferObjects\Category;

use Illuminate\Http\Request;

class CategoryCreateDTO
{
    public function __construct(
        public readonly string $name
    )
    {
    }

    /**
     * @throws \Exception
     */
    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->input('name')
        );
    }
}
