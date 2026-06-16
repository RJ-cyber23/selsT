<?php

namespace App\DTOs;

class CategoryDTO
{
    public function __construct(
        public readonly ?int $category_id = null,
        public readonly ?string $category_name = null,
    ) {}
}
