<?php

namespace App\Domain\Certification\Events;

use App\Domain\Certification\Models\Certification;
use App\Domain\Shared\Events\DomainEvent;

class CertificationGenerated extends DomainEvent
{
    public function __construct(
        public readonly Certification $certification
    ) {
        parent::__construct();
    }
}

