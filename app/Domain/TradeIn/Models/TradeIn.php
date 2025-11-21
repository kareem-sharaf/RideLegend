<?php

namespace App\Domain\TradeIn\Models;

use App\Domain\TradeIn\Events\TradeInApproved;
use App\Domain\TradeIn\Events\TradeInRejected;
use App\Domain\TradeIn\Events\TradeInValuated;
use App\Domain\TradeIn\ValueObjects\TradeInStatus;
use App\Domain\Product\ValueObjects\Price;
use App\Domain\Shared\Events\DomainEvent;
use Illuminate\Support\Collection;

class TradeIn
{
    private Collection $domainEvents;

    public function __construct(
        private ?int $id,
        private int $buyerId,
        private TradeInStatus $status,
        private ?\DateTimeImmutable $requestedAt = null,
        private ?\DateTimeImmutable $approvedAt = null,
        private ?\DateTimeImmutable $rejectedAt = null,
        private ?string $rejectionReason = null,
        private ?\DateTimeImmutable $createdAt = null,
        private ?\DateTimeImmutable $updatedAt = null,
    ) {
        $this->domainEvents = new Collection();
    }

    public static function create(int $buyerId): self
    {
        $tradeIn = new self(
            id: null,
            buyerId: $buyerId,
            status: TradeInStatus::pending(),
            requestedAt: new \DateTimeImmutable(),
            createdAt: new \DateTimeImmutable(),
            updatedAt: new \DateTimeImmutable(),
        );

        return $tradeIn;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBuyerId(): int
    {
        return $this->buyerId;
    }

    public function getStatus(): TradeInStatus
    {
        return $this->status;
    }

    public function getRequestedAt(): ?\DateTimeImmutable
    {
        return $this->requestedAt;
    }

    public function getApprovedAt(): ?\DateTimeImmutable
    {
        return $this->approvedAt;
    }

    public function getRejectedAt(): ?\DateTimeImmutable
    {
        return $this->rejectedAt;
    }

    public function getRejectionReason(): ?string
    {
        return $this->rejectionReason;
    }

    public function valuate(): void
    {
        if (!$this->status->isPending()) {
            throw new \DomainException('Only pending trade-ins can be valuated');
        }

        $this->status = TradeInStatus::valuated();
        $this->updatedAt = new \DateTimeImmutable();

        $this->recordEvent(new TradeInValuated($this));
    }

    public function approve(): void
    {
        if (!$this->status->isValuated()) {
            throw new \DomainException('Only valuated trade-ins can be approved');
        }

        $this->status = TradeInStatus::approved();
        $this->approvedAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();

        $this->recordEvent(new TradeInApproved($this));
    }

    public function reject(?string $reason = null): void
    {
        if ($this->status->isApproved() || $this->status->isCompleted()) {
            throw new \DomainException('Cannot reject approved or completed trade-ins');
        }

        $this->status = TradeInStatus::rejected();
        $this->rejectedAt = new \DateTimeImmutable();
        $this->rejectionReason = $reason;
        $this->updatedAt = new \DateTimeImmutable();

        $this->recordEvent(new TradeInRejected($this, $reason));
    }

    public function complete(): void
    {
        if (!$this->status->isApproved()) {
            throw new \DomainException('Only approved trade-ins can be completed');
        }

        $this->status = TradeInStatus::completed();
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

