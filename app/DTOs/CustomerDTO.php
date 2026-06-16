<?php

namespace App\DTOs;

class CustomerDTO
{
    public function __construct(
        public readonly ?int $customer_id = null,
        public readonly ?string $first_name = null,
        public readonly ?string $last_name = null,
        public readonly ?string $bod = null,
        public readonly ?string $phone_number = null,
        public readonly ?string $Gmail = null,
        public readonly ?string $location_address = null,
    ) {}
}
