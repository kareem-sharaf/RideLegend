<?php

namespace App\Application\TradeIn\DTOs;

readonly class EvaluateTradeInDTO
{
    public function __construct(
        public int $tradeInId,
        public float $valuationAmount,
        public ?string $notes = null,
    ) {}
}

