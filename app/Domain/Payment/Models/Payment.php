<?php

namespace App\Domain\Payment\Models;

use App\Domain\Order\Models\Order;
use App\Domain\Payment\Events\PaymentCompleted;
use App\Domain\Payment\Events\PaymentFailed;
use App\Domain\Payment\ValueObjects\PaymentMethod;
use App\Domain\Payment\ValueObjects\PaymentStatus;
use App\Domain\Product\ValueObjects\Price;
use App\Domain\Shared\Events\DomainEvent;
use Illuminate\Support\Collection;

class Payment
{
    private Collection $domainEvents;

    public function __construct(
        private ?int $id,
        private int $orderId,
        private int $userId,
        private PaymentMethod $paymentMethod,
        private Price $amount,
        private string $currency = 'USD',
        private PaymentStatus $status,
        private ?string $transactionId = null,
        private ?array $gatewayResponse = null,
        private ?\DateTimeImmutable $processedAt = null,
        private ?\DateTimeImmutable $createdAt = null,
        private ?\DateTimeImmutable $updatedAt = null,
    ) {
        $this->domainEvents = new Collection();
    }

    public static function create(
        int $orderId,
        int $userId,
        PaymentMethod $paymentMethod,
        Price $amount,
        string $currency = 'USD'
    ): self {
        $payment = new self(
            id: null,
            orderId: $orderId,
            userId: $userId,
            paymentMethod: $paymentMethod,
            amount: $amount,
            currency: $currency,
            status: PaymentStatus::pending(),
            createdAt: new \DateTimeImmutable(),
            updatedAt: new \DateTimeImmutable(),
        );

        return $payment;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getPaymentMethod(): PaymentMethod
    {
        return $this->paymentMethod;
    }

    public function getAmount(): Price
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getStatus(): PaymentStatus
    {
        return $this->status;
    }

    public function getTransactionId(): ?string
    {
        return $this->transactionId;
    }

    public function getGatewayResponse(): ?array
    {
        return $this->gatewayResponse;
    }

    public function getProcessedAt(): ?\DateTimeImmutable
    {
        return $this->processedAt;
    }

    public function markAsProcessing(): void
    {
        $this->status = PaymentStatus::processing();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function complete(string $transactionId, ?array $gatewayResponse = null): void
    {
        if (!$this->status->isPending() && !$this->status->isProcessing()) {
            throw new \DomainException('Only pending or processing payments can be completed');
        }

        $this->status = PaymentStatus::completed();
        $this->transactionId = $transactionId;
        $this->gatewayResponse = $gatewayResponse;
        $this->processedAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();

        $this->recordEvent(new PaymentCompleted($this));
    }

    public function fail(?string $reason = null): void
    {
        if ($this->status->isCompleted() || $this->status->isRefunded()) {
            throw new \DomainException('Cannot fail completed or refunded payments');
        }

        $this->status = PaymentStatus::failed();
        $this->updatedAt = new \DateTimeImmutable();

        if ($reason) {
            $this->gatewayResponse = array_merge($this->gatewayResponse ?? [], ['failure_reason' => $reason]);
        }

        $this->recordEvent(new PaymentFailed($this, $reason));
    }

    public function refund(): void
    {
        if (!$this->status->isCompleted()) {
            throw new \DomainException('Only completed payments can be refunded');
        }

        $this->status = PaymentStatus::refunded();
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

