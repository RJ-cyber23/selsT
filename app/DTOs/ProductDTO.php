<?php

namespace App\DTOs;

class ProductDTO
{
    public function __construct(
        public readonly ?int $product_id = null,
        public readonly ?string $product_name = null,
        public readonly ?int $category_id = null,
        public readonly ?string $size = null,
        public readonly ?int $quantity = null,
        public readonly ?int $uom_id = null,
        public readonly ?float $weight = null,
        public readonly ?int $supplier_id = null,
        public readonly ?int $brand_id = null,
        public readonly ?float $mark_up = null,
        public readonly ?float $cost_price = null,
    ) {}
}
