<?php

namespace App\Infrastructure\Repositories\Order;

use App\Domain\Order\Models\Order;
use App\Domain\Order\Models\OrderItem;
use App\Domain\Order\Repositories\OrderRepositoryInterface;
use App\Domain\Order\ValueObjects\OrderNumber;
use App\Domain\Order\ValueObjects\OrderStatus;
use App\Domain\Product\ValueObjects\Price;
use App\Models\Order as EloquentOrder;
use App\Models\OrderItem as EloquentOrderItem;
use Illuminate\Support\Collection;

class EloquentOrderRepository implements OrderRepositoryInterface
{
    public function save(Order $order): void
    {
        $eloquent = EloquentOrder::updateOrCreate(
            ['id' => $order->getId()],
            [
                'order_number' => $order->getOrderNumber()->getValue(),
                'buyer_id' => $order->getBuyerId(),
                'status' => $order->getStatus()->getValue(),
                'subtotal' => $order->getSubtotal()->getAmount(),
                'tax' => $order->getTax()->getAmount(),
                'shipping_cost' => $order->getShippingCost()->getAmount(),
                'discount' => $order->getDiscount()->getAmount(),
                'total' => $order->getTotal()->getAmount(),
                'currency' => $order->getCurrency(),
                'placed_at' => $order->getPlacedAt(),
            ]
        );

        // Save order items
        if ($order->getItems()->isNotEmpty()) {
            $eloquent->items()->delete();
            foreach ($order->getItems() as $item) {
                $eloquent->items()->create([
                    'product_id' => $item->getProductId(),
                    'quantity' => $item->getQuantity(),
                    'unit_price' => $item->getUnitPrice()->getAmount(),
                    'total_price' => $item->getTotalPrice()->getAmount(),
                ]);
            }
        }

        // Update order ID in domain model if it was new
        if (!$order->getId()) {
            $reflection = new \ReflectionClass($order);
            $idProperty = $reflection->getProperty('id');
            $idProperty->setAccessible(true);
            $idProperty->setValue($order, $eloquent->id);
        }
    }

    public function findById(int $id): ?Order
    {
        $eloquent = EloquentOrder::with('items')->find($id);

        return $eloquent ? $this->toDomain($eloquent) : null;
    }

    public function findByOrderNumber(OrderNumber $orderNumber): ?Order
    {
        $eloquent = EloquentOrder::with('items')
            ->where('order_number', $orderNumber->getValue())
            ->first();

        return $eloquent ? $this->toDomain($eloquent) : null;
    }

    public function findByBuyerId(int $buyerId): array
    {
        $eloquents = EloquentOrder::with('items')
            ->where('buyer_id', $buyerId)
            ->orderBy('created_at', 'desc')
            ->get();

        return $eloquents->map(fn($eloquent) => $this->toDomain($eloquent))->toArray();
    }

    public function delete(Order $order): void
    {
        if ($order->getId()) {
            EloquentOrder::destroy($order->getId());
        }
    }

    private function toDomain(EloquentOrder $eloquent): Order
    {
        $orderNumber = OrderNumber::fromString($eloquent->order_number);
        $status = OrderStatus::fromString($eloquent->status);
        $subtotal = Price::fromAmount($eloquent->subtotal, $eloquent->currency);
        $tax = Price::fromAmount($eloquent->tax, $eloquent->currency);
        $shippingCost = Price::fromAmount($eloquent->shipping_cost, $eloquent->currency);
        $discount = Price::fromAmount($eloquent->discount, $eloquent->currency);
        $total = Price::fromAmount($eloquent->total, $eloquent->currency);

        $order = new Order(
            id: $eloquent->id,
            orderNumber: $orderNumber,
            buyerId: $eloquent->buyer_id,
            status: $status,
            subtotal: $subtotal,
            tax: $tax,
            shippingCost: $shippingCost,
            discount: $discount,
            total: $total,
            currency: $eloquent->currency,
            placedAt: $eloquent->placed_at?->toImmutable(),
            createdAt: $eloquent->created_at?->toImmutable(),
            updatedAt: $eloquent->updated_at?->toImmutable(),
        );

        // Add order items
        $items = $eloquent->items->map(function ($item) {
            return new OrderItem(
                id: $item->id,
                productId: $item->product_id,
                quantity: $item->quantity,
                unitPrice: Price::fromAmount($item->unit_price, $item->order->currency ?? 'USD'),
                totalPrice: Price::fromAmount($item->total_price, $item->order->currency ?? 'USD'),
            );
        });

        $order->setItems($items);

        return $order;
    }
}

