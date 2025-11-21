<?php

namespace App\Application\TradeIn\DTOs;

readonly class RejectTradeInDTO
{
    public function __construct(
        public int $tradeInId,
        public string $reason,
    ) {}
}

