<?php

namespace App\Application\TradeIn\DTOs;

readonly class SubmitTradeInRequestDTO
{
    public function __construct(
        public int $buyerId,
        public string $brand,
        public string $model,
        public ?int $year = null,
        public ?string $condition = null,
        public ?string $description = null,
        public ?array $images = null,
    ) {}
}

