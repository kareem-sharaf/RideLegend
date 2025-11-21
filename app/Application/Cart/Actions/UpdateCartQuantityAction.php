<?php

namespace App\Application\Cart\Actions;

use App\Application\Cart\DTOs\UpdateCartQuantityDTO;
use App\Domain\Cart\Repositories\CartRepositoryInterface;

class UpdateCartQuantityAction
{
    public function __construct(
        private CartRepositoryInterface $cartRepository,
    ) {}

    public function execute(UpdateCartQuantityDTO $dto): void
    {
        $cartItem = $this->cartRepository->findById($dto->cartItemId);

        if (!$cartItem) {
            throw new \DomainException('Cart item not found');
        }

        if ($cartItem->getUserId() !== $dto->userId) {
            throw new \DomainException('Unauthorized: Cart item does not belong to user');
        }

        $cartItem->updateQuantity($dto->quantity);
        $this->cartRepository->save($cartItem);
    }
}

