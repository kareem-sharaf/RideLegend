<?php

namespace App\Domain\Payment\Events;

use App\Domain\Payment\Models\Payment;
use App\Domain\Shared\Events\DomainEvent;

class PaymentCompleted extends DomainEvent
{
    public function __construct(
        public readonly Payment $payment
    ) {
        parent::__construct();
    }
}

