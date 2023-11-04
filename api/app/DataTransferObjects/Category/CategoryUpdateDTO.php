<?php

namespace App\DataTransferObjects\Category;

use Illuminate\Http\Request;

class CategoryUpdateDTO
{
    public function __construct(
        public readonly ?string $name = null
    )
    {
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
        return new self(
            $name
        );
    }
}
