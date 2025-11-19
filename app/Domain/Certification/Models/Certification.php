<?php

namespace App\Domain\Certification\Models;

use App\Domain\Certification\Events\CertificationGenerated;
use App\Domain\Inspection\ValueObjects\OverallGrade;
use App\Domain\Shared\Events\DomainEvent;
use Illuminate\Support\Collection;

class Certification
{
    private Collection $domainEvents;

    public function __construct(
        private ?int $id,
        private int $productId,
        private int $inspectionId,
        private int $workshopId,
        private OverallGrade $grade,
        private string $reportUrl,
        private string $status = 'active',
        private ?\DateTimeImmutable $issuedAt = null,
        private ?\DateTimeImmutable $expiresAt = null,
        private ?\DateTimeImmutable $createdAt = null,
        private ?\DateTimeImmutable $updatedAt = null,
    ) {
        $this->domainEvents = new Collection();
    }

    public static function create(
        int $productId,
        int $inspectionId,
        int $workshopId,
        OverallGrade $grade,
        string $reportUrl,
        ?\DateTimeImmutable $expiresAt = null
    ): self {
        $certification = new self(
            id: null,
            productId: $productId,
            inspectionId: $inspectionId,
            workshopId: $workshopId,
            grade: $grade,
            reportUrl: $reportUrl,
            status: 'active',
            issuedAt: new \DateTimeImmutable(),
            expiresAt: $expiresAt ?? (new \DateTimeImmutable())->modify('+1 year'),
            createdAt: new \DateTimeImmutable(),
            updatedAt: new \DateTimeImmutable(),
        );

        $certification->recordEvent(new CertificationGenerated($certification));

        return $certification;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getInspectionId(): int
    {
        return $this->inspectionId;
    }

    public function getWorkshopId(): int
    {
        return $this->workshopId;
    }

    public function getGrade(): OverallGrade
    {
        return $this->grade;
    }

    public function getReportUrl(): string
    {
        return $this->reportUrl;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getIssuedAt(): ?\DateTimeImmutable
    {
        return $this->issuedAt;
    }

    public function getExpiresAt(): ?\DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function isExpired(): bool
    {
        if ($this->expiresAt === null) {
            return false;
        }

        return $this->expiresAt < new \DateTimeImmutable();
    }

    public function revoke(): void
    {
        $this->status = 'revoked';
        $this->updatedAt = new \DateTimeImmutable();
    }

    protected function recordEvent(DomainEvent $event): void
    {
        $this->domainEvents->push($event);
    }

    public function getDomainEvents(): Collection
    {
        return $this->domainEvents;
    }

    public function clearDomainEvents(): void
    {
        $this->domainEvents = new Collection();
    }
}

