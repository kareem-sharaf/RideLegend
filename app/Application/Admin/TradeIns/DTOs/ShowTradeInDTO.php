<?php

namespace App\Application\Admin\TradeIns\DTOs;

readonly class ShowTradeInDTO
{
    public function __construct(
        public int $tradeInId,
    ) {}
}

