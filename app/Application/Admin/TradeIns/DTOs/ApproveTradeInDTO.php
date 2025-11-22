<?php

namespace App\Application\Admin\TradeIns\DTOs;

readonly class ApproveTradeInDTO
{
    public function __construct(
        public int $tradeInId,
    ) {}
}

