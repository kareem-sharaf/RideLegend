<?php

namespace App\Domain\User\Events;

use App\Domain\Shared\Events\DomainEvent;
use App\Domain\User\Models\User;

class RoleAssigned extends DomainEvent
{
    public function __construct(
        public readonly User $user,
        public readonly string $role
    ) {
        parent::__construct();
    }
}

