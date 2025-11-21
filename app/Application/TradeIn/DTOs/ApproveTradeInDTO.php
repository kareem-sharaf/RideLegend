<?php

namespace App\Application\TradeIn\DTOs;

readonly class ApproveTradeInDTO
{
    public function __construct(
        public int $tradeInId,
    ) {}
}

