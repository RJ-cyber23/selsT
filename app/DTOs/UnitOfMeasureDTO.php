<?php

namespace App\DTOs;

class UnitOfMeasureDTO
{
    public function __construct(
        public readonly ?int $uom_id = null,
        public readonly ?string $uom_name = null,
    ) {}
}
