<?php

namespace App\Http\Resources;

use App\Domain\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var User $user */
        $user = $this->resource;

        return [
            'id' => $user->getId(),
            'email' => $user->getEmail()->toString(),
            'role' => $user->getRole(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'full_name' => $user->getFullName(),
            'phone' => $user->getPhone()?->toString(),
            'avatar' => $user->getAvatar() ? asset('storage/' . $user->getAvatar()) : null,
            'email_verified' => $user->isEmailVerified(),
            'created_at' => $user->getId() ? now()->toIso8601String() : null,
        ];
    }
}

