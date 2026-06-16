<?php

namespace App\DTOs;

class BrandDTO
{
    public function __construct(
        public readonly ?int $brand_id = null,
        public readonly ?string $brand_name = null,
    ) {}
}
