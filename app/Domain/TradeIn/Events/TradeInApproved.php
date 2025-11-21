<?php

namespace App\Domain\TradeIn\Events;

use App\Domain\Shared\Events\DomainEvent;
use App\Domain\TradeIn\Models\TradeIn;

class TradeInApproved extends DomainEvent
{
    public function __construct(
        public readonly TradeIn $tradeIn
    ) {
        parent::__construct();
    }
}

