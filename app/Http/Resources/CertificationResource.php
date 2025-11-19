<?php

namespace App\Http\Resources;

use App\Domain\Certification\Models\Certification;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CertificationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var Certification $certification */
        $certification = $this->resource;

        return [
            'id' => $certification->getId(),
            'product_id' => $certification->getProductId(),
            'inspection_id' => $certification->getInspectionId(),
            'workshop_id' => $certification->getWorkshopId(),
            'grade' => $certification->getGrade()->toString(),
            'report_url' => asset('storage/' . $certification->getReportUrl()),
            'status' => $certification->getStatus(),
            'issued_at' => $certification->getIssuedAt()?->format('Y-m-d H:i:s'),
            'expires_at' => $certification->getExpiresAt()?->format('Y-m-d H:i:s'),
            'is_expired' => $certification->isExpired(),
        ];
    }
}

