<?php

namespace App\Domain\Payment\Events;

use App\Domain\Payment\Models\Payment;
use App\Domain\Shared\Events\DomainEvent;

class PaymentFailed extends DomainEvent
{
    public function __construct(
        public readonly Payment $payment,
        public readonly ?string $reason = null
    ) {
        parent::__construct();
    }
}

