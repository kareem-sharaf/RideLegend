<?php

namespace App\Domain\Certification\Repositories;

use App\Domain\Certification\Models\Certification;

interface CertificationRepositoryInterface
{
    public function save(Certification $certification): Certification;

    public function findById(int $id): ?Certification;

    public function findByProductId(int $productId): ?Certification;

    public function delete(Certification $certification): void;
}

