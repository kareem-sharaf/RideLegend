<?php

namespace App\Application\Cart\Actions;

use App\Application\Cart\DTOs\RemoveFromCartDTO;
use App\Domain\Cart\Repositories\CartRepositoryInterface;

class RemoveFromCartAction
{
    public function __construct(
        private CartRepositoryInterface $cartRepository,
    ) {}

    public function execute(RemoveFromCartDTO $dto): void
    {
        $cartItem = $this->cartRepository->findById($dto->cartItemId);

        if (!$cartItem) {
            throw new \DomainException('Cart item not found');
        }

        if ($cartItem->getUserId() !== $dto->userId) {
            throw new \DomainException('Unauthorized: Cart item does not belong to user');
        }

        $this->cartRepository->delete($cartItem);
    }
}

