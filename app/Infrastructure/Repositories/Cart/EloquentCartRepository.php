<?php

namespace App\Infrastructure\Repositories\Cart;

use App\Domain\Cart\Models\CartItem;
use App\Domain\Cart\Repositories\CartRepositoryInterface;
use App\Domain\Product\ValueObjects\Price;
use App\Models\CartItem as EloquentCartItem;

class EloquentCartRepository implements CartRepositoryInterface
{
    public function save(CartItem $cartItem): CartItem
    {
        $eloquent = EloquentCartItem::updateOrCreate(
            [
                'id' => $cartItem->getId(),
            ],
            [
                'user_id' => $cartItem->getUserId(),
                'product_id' => $cartItem->getProductId(),
                'quantity' => $cartItem->getQuantity(),
                'unit_price' => $cartItem->getUnitPrice()?->getAmount(),
            ]
        );

        return $this->toDomain($eloquent);
    }

    public function findById(int $id): ?CartItem
    {
        $eloquent = EloquentCartItem::find($id);

        return $eloquent ? $this->toDomain($eloquent) : null;
    }

    public function findByUserId(int $userId): array
    {
        $eloquents = EloquentCartItem::where('user_id', $userId)->get();

        return $eloquents->map(fn($eloquent) => $this->toDomain($eloquent))->toArray();
    }

    public function findByUserAndProduct(int $userId, int $productId): ?CartItem
    {
        $eloquent = EloquentCartItem::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        return $eloquent ? $this->toDomain($eloquent) : null;
    }

    public function delete(CartItem $cartItem): void
    {
        if ($cartItem->getId()) {
            EloquentCartItem::destroy($cartItem->getId());
        }
    }

    public function clearUserCart(int $userId): void
    {
        EloquentCartItem::where('user_id', $userId)->delete();
    }

    private function toDomain(EloquentCartItem $eloquent): CartItem
    {
        $unitPrice = $eloquent->unit_price 
            ? Price::fromAmount($eloquent->unit_price) 
            : null;

        return new CartItem(
            id: $eloquent->id,
            userId: $eloquent->user_id,
            productId: $eloquent->product_id,
            quantity: $eloquent->quantity,
            unitPrice: $unitPrice,
            createdAt: $eloquent->created_at?->toImmutable(),
            updatedAt: $eloquent->updated_at?->toImmutable(),
        );
    }
}

