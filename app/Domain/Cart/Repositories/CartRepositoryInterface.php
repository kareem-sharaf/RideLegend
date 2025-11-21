<?php

namespace App\Domain\Cart\Repositories;

use App\Domain\Cart\Models\CartItem;

interface CartRepositoryInterface
{
    public function save(CartItem $cartItem): CartItem;

    public function findById(int $id): ?CartItem;

    public function findByUserId(int $userId): array;

    public function findByUserAndProduct(int $userId, int $productId): ?CartItem;

    public function delete(CartItem $cartItem): void;

    public function clearUserCart(int $userId): void;
}
