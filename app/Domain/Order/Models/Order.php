<?php

namespace App\Domain\Order\Models;

use App\Domain\Order\Events\OrderCreated;
use App\Domain\Order\Events\OrderStatusChanged;
use App\Domain\Order\ValueObjects\OrderNumber;
use App\Domain\Order\ValueObjects\OrderStatus;
use App\Domain\Product\ValueObjects\Price;
use App\Domain\Shared\Events\DomainEvent;
use Illuminate\Support\Collection;

class Order
{
    private Collection $domainEvents;
    private Collection $items;

    public function __construct(
        private ?int $id,
        private OrderNumber $orderNumber,
        private int $buyerId,
        private OrderStatus $status,
        private Price $subtotal,
        private Price $tax,
        private Price $shippingCost,
        private Price $discount,
        private Price $total,
        private string $currency = 'USD',
        private ?\DateTimeImmutable $placedAt = null,
        private ?\DateTimeImmutable $createdAt = null,
        private ?\DateTimeImmutable $updatedAt = null,
    ) {
        $this->domainEvents = new Collection();
        $this->items = new Collection();
    }

    public static function create(
        OrderNumber $orderNumber,
        int $buyerId,
        Price $subtotal,
        Price $tax,
        Price $shippingCost,
        Price $discount,
        Price $total,
        string $currency = 'USD'
    ): self {
        $order = new self(
            id: null,
            orderNumber: $orderNumber,
            buyerId: $buyerId,
            status: OrderStatus::pending(),
            subtotal: $subtotal,
            tax: $tax,
            shippingCost: $shippingCost,
            discount: $discount,
            total: $total,
            currency: $currency,
            placedAt: new \DateTimeImmutable(),
            createdAt: new \DateTimeImmutable(),
            updatedAt: new \DateTimeImmutable(),
        );

        $order->recordEvent(new OrderCreated($order));

        return $order;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderNumber(): OrderNumber
    {
        return $this->orderNumber;
    }

    public function getBuyerId(): int
    {
        return $this->buyerId;
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    public function getSubtotal(): Price
    {
        return $this->subtotal;
    }

    public function getTax(): Price
    {
        return $this->tax;
    }

    public function getShippingCost(): Price
    {
        return $this->shippingCost;
    }

    public function getDiscount(): Price
    {
        return $this->discount;
    }

    public function getTotal(): Price
    {
        return $this->total;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getPlacedAt(): ?\DateTimeImmutable
    {
        return $this->placedAt;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(OrderItem $item): void
    {
        $this->items->push($item);
    }

    public function setItems(Collection $items): void
    {
        $this->items = $items;
    }

    public function changeStatus(OrderStatus $newStatus): void
    {
        $oldStatus = $this->status;
        $this->status = $newStatus;
        $this->updatedAt = new \DateTimeImmutable();

        $this->recordEvent(new OrderStatusChanged($this, $oldStatus, $newStatus));
    }

    public function confirm(): void
    {
        if (!$this->status->isPending()) {
            throw new \DomainException('Only pending orders can be confirmed');
        }

        $this->changeStatus(OrderStatus::confirmed());
    }

    public function markAsProcessing(): void
    {
        if (!$this->status->isConfirmed()) {
            throw new \DomainException('Only confirmed orders can be processed');
        }

        $this->changeStatus(OrderStatus::processing());
    }

    public function markAsShipped(): void
    {
        if (!$this->status->isProcessing()) {
            throw new \DomainException('Only processing orders can be shipped');
        }

        $this->changeStatus(OrderStatus::shipped());
    }

    public function markAsDelivered(): void
    {
        if (!$this->status->isShipped()) {
            throw new \DomainException('Only shipped orders can be delivered');
        }

        $this->changeStatus(OrderStatus::delivered());
    }

    public function cancel(): void
    {
        if ($this->status->isDelivered() || $this->status->isCancelled()) {
            throw new \DomainException('Cannot cancel delivered or already cancelled orders');
        }

        $this->changeStatus(OrderStatus::cancelled());
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
