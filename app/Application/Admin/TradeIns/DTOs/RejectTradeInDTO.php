<?php

namespace App\Application\Admin\TradeIns\DTOs;

readonly class RejectTradeInDTO
{
    public function __construct(
        public int $tradeInId,
        public string $reason,
    ) {}
}

