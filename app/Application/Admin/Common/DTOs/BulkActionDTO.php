<?php

namespace App\Application\Admin\Common\DTOs;

readonly class BulkActionDTO
{
    /**
     * @param array<int> $ids
     */
    public function __construct(
        public string $action,
        public array $ids,
        public ?array $data = null,
    ) {}
}

