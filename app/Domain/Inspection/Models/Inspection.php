<?php

namespace App\Domain\Inspection\Models;

use App\Domain\Inspection\Events\InspectionCompleted;
use App\Domain\Inspection\Events\InspectionRequested;
use App\Domain\Inspection\ValueObjects\BrakeCondition;
use App\Domain\Inspection\ValueObjects\FrameCondition;
use App\Domain\Inspection\ValueObjects\GroupsetCondition;
use App\Domain\Inspection\ValueObjects\OverallGrade;
use App\Domain\Inspection\ValueObjects\WheelsCondition;
use App\Domain\Shared\Events\DomainEvent;
use Illuminate\Support\Collection;

class Inspection
{
    private Collection $domainEvents;
    private Collection $images;

    public function __construct(
        private ?int $id,
        private int $productId,
        private int $sellerId,
        private int $workshopId,
        private string $status = 'pending',
        private ?FrameCondition $frameCondition = null,
        private ?BrakeCondition $brakeCondition = null,
        private ?GroupsetCondition $groupsetCondition = null,
        private ?WheelsCondition $wheelsCondition = null,
        private ?OverallGrade $overallGrade = null,
        private ?string $notes = null,
        private ?\DateTimeImmutable $requestedAt = null,
        private ?\DateTimeImmutable $scheduledAt = null,
        private ?\DateTimeImmutable $completedAt = null,
        private ?\DateTimeImmutable $createdAt = null,
        private ?\DateTimeImmutable $updatedAt = null,
    ) {
        $this->domainEvents = new Collection();
        $this->images = new Collection();
    }

    public static function create(
        int $productId,
        int $sellerId,
        int $workshopId
    ): self {
        $inspection = new self(
            id: null,
            productId: $productId,
            sellerId: $sellerId,
            workshopId: $workshopId,
            status: 'pending',
            requestedAt: new \DateTimeImmutable(),
            createdAt: new \DateTimeImmutable(),
            updatedAt: new \DateTimeImmutable(),
        );

        $inspection->recordEvent(new InspectionRequested($inspection));

        return $inspection;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getSellerId(): int
    {
        return $this->sellerId;
    }

    public function getWorkshopId(): int
    {
        return $this->workshopId;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getFrameCondition(): ?FrameCondition
    {
        return $this->frameCondition;
    }

    public function getBrakeCondition(): ?BrakeCondition
    {
        return $this->brakeCondition;
    }

    public function getGroupsetCondition(): ?GroupsetCondition
    {
        return $this->groupsetCondition;
    }

    public function getWheelsCondition(): ?WheelsCondition
    {
        return $this->wheelsCondition;
    }

    public function getOverallGrade(): ?OverallGrade
    {
        return $this->overallGrade;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function getImages(): Collection
    {
        return $this->images;
    }

    public function schedule(\DateTimeImmutable $scheduledAt): void
    {
        $this->scheduledAt = $scheduledAt;
        $this->status = 'scheduled';
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function submitReport(
        FrameCondition $frameCondition,
        BrakeCondition $brakeCondition,
        GroupsetCondition $groupsetCondition,
        WheelsCondition $wheelsCondition,
        OverallGrade $overallGrade,
        ?string $notes = null
    ): void {
        $this->frameCondition = $frameCondition;
        $this->brakeCondition = $brakeCondition;
        $this->groupsetCondition = $groupsetCondition;
        $this->wheelsCondition = $wheelsCondition;
        $this->overallGrade = $overallGrade;
        $this->notes = $notes;
        $this->status = 'completed';
        $this->completedAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();

        $this->recordEvent(new InspectionCompleted($this));
    }

    public function addImage(string $path): void
    {
        $this->images->push($path);
    }

    public function setImages(Collection $images): void
    {
        $this->images = $images;
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
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

