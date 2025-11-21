<?php

namespace App\Application\Cart\Actions;

use App\Application\Cart\DTOs\GetUserCartDTO;
use App\Domain\Cart\Repositories\CartRepositoryInterface;

class GetUserCartAction
{
    public function __construct(
        private CartRepositoryInterface $cartRepository,
    ) {}

    public function execute(GetUserCartDTO $dto): array
    {
        return $this->cartRepository->findByUserId($dto->userId);
    }
}

