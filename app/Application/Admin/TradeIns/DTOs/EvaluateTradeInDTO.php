<?php

namespace App\Application\Admin\TradeIns\DTOs;

readonly class EvaluateTradeInDTO
{
    public function __construct(
        public int $tradeInId,
        public float $valuationAmount,
        public ?string $notes = null,
    ) {}
}

