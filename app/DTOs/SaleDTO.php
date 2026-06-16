<?php

namespace App\DTOs;

class SaleDTO
{
    public function __construct(
        public readonly ?int $sale_id = null,
        public readonly ?int $product_id = null,
        public readonly ?int $customer_id = null,
        public readonly ?int $quantity = null,
    ) {}
}
