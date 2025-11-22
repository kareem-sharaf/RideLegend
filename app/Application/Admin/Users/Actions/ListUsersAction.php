<?php

namespace App\Application\Admin\Users\Actions;

use App\Application\Admin\Users\DTOs\ListUsersDTO;
use App\Domain\User\Repositories\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListUsersAction
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {}

    public function execute(ListUsersDTO $dto): LengthAwarePaginator
    {
        // This will be implemented in the repository
        // For now, return paginated users from Eloquent
        $query = \App\Models\User::query();

        if ($dto->role) {
            $query->whereHas('roles', function($q) use ($dto) {
                $q->where('name', $dto->role);
            });
        }

        if ($dto->search) {
            $query->where(function($q) use ($dto) {
                $q->where('first_name', 'like', "%{$dto->search}%")
                  ->orWhere('last_name', 'like', "%{$dto->search}%")
                  ->orWhere('email', 'like', "%{$dto->search}%");
            });
        }

        if ($dto->status) {
            if ($dto->status === 'active') {
                $query->whereNotNull('email_verified_at');
            } elseif ($dto->status === 'inactive') {
                $query->whereNull('email_verified_at');
            }
        }

        return $query->orderBy($dto->sortBy, $dto->sortDirection)
            ->paginate($dto->perPage, ['*'], 'page', $dto->page);
    }
}

