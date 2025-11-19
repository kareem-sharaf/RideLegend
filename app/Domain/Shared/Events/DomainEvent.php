<?php

namespace App\Domain\Shared\Events;

use Illuminate\Queue\SerializesModels;

abstract class DomainEvent
{
    use SerializesModels;

    public function __construct(
        public readonly \DateTimeImmutable $occurredOn = new \DateTimeImmutable()
    ) {}
}

