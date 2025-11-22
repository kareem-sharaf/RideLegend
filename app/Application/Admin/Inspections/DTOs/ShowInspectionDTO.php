<?php

namespace App\Application\Admin\Inspections\DTOs;

readonly class ShowInspectionDTO
{
    public function __construct(
        public int $inspectionId,
    ) {}
}

