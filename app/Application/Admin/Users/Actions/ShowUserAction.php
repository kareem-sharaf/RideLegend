<?php

namespace App\Application\Admin\Users\Actions;

use App\Application\Admin\Users\DTOs\ShowUserDTO;
use App\Domain\User\Repositories\UserRepositoryInterface;

class ShowUserAction
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {}

    public function execute(ShowUserDTO $dto): array
    {
        $user = $this->userRepository->findById($dto->userId);

        if (!$user) {
            throw new \DomainException('User not found');
        }

        // Get user statistics
        $stats = [
            'total_products' => \App\Models\Product::where('seller_id', $dto->userId)->count(),
            'total_orders' => \App\Models\Order::where('buyer_id', $dto->userId)->count(),
            'total_spent' => \App\Models\Order::where('buyer_id', $dto->userId)
                ->where('status', '!=', 'cancelled')
                ->sum('total'),
        ];

        return [
            'user' => $user,
            'stats' => $stats,
        ];
    }
}

