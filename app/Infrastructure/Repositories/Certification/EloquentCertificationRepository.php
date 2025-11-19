<?php

namespace App\Infrastructure\Repositories\Certification;

use App\Domain\Certification\Models\Certification;
use App\Domain\Certification\Repositories\CertificationRepositoryInterface;
use App\Domain\Inspection\ValueObjects\OverallGrade;
use App\Models\Certification as EloquentCertification;

class EloquentCertificationRepository implements CertificationRepositoryInterface
{
    public function save(Certification $certification): Certification
    {
        $eloquent = EloquentCertification::updateOrCreate(
            ['id' => $certification->getId()],
            [
                'product_id' => $certification->getProductId(),
                'inspection_id' => $certification->getInspectionId(),
                'workshop_id' => $certification->getWorkshopId(),
                'grade' => $certification->getGrade()->toString(),
                'report_url' => $certification->getReportUrl(),
                'status' => $certification->getStatus(),
                'issued_at' => $certification->getIssuedAt()?->format('Y-m-d H:i:s'),
                'expires_at' => $certification->getExpiresAt()?->format('Y-m-d H:i:s'),
            ]
        );

        return $this->toDomain($eloquent);
    }

    public function findById(int $id): ?Certification
    {
        $eloquent = EloquentCertification::find($id);

        return $eloquent ? $this->toDomain($eloquent) : null;
    }

    public function findByProductId(int $productId): ?Certification
    {
        $eloquent = EloquentCertification::where('product_id', $productId)->first();

        return $eloquent ? $this->toDomain($eloquent) : null;
    }

    public function delete(Certification $certification): void
    {
        if ($certification->getId()) {
            EloquentCertification::destroy($certification->getId());
        }
    }

    private function toDomain(EloquentCertification $eloquent): Certification
    {
        return new Certification(
            id: $eloquent->id,
            productId: $eloquent->product_id,
            inspectionId: $eloquent->inspection_id,
            workshopId: $eloquent->workshop_id,
            grade: OverallGrade::fromString($eloquent->grade),
            reportUrl: $eloquent->report_url,
            status: $eloquent->status ?? 'active',
            issuedAt: $eloquent->issued_at ? \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $eloquent->issued_at) : null,
            expiresAt: $eloquent->expires_at ? \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $eloquent->expires_at) : null,
            createdAt: $eloquent->created_at ? \DateTimeImmutable::createFromMutable($eloquent->created_at) : null,
            updatedAt: $eloquent->updated_at ? \DateTimeImmutable::createFromMutable($eloquent->updated_at) : null,
        );
    }
}

