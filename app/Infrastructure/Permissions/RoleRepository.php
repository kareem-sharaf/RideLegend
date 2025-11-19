<?php

namespace App\Infrastructure\Permissions;

use App\Domain\User\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleRepository
{
    public function assignRole(User $user, string $roleName): void
    {
        $eloquentUser = \App\Models\User::find($user->getId());
        if ($eloquentUser) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $eloquentUser->assignRole($role);
        }
    }

    public function hasRole(User $user, string $roleName): bool
    {
        $eloquentUser = \App\Models\User::find($user->getId());
        return $eloquentUser?->hasRole($roleName) ?? false;
    }

    public function getRoles(User $user): array
    {
        $eloquentUser = \App\Models\User::find($user->getId());
        return $eloquentUser?->getRoleNames()->toArray() ?? [];
    }

    public function createRole(string $name, string $displayName = null): Role
    {
        return Role::firstOrCreate(
            ['name' => $name],
            ['name' => $name]
        );
    }

    public function createPermission(string $name, string $displayName = null): Permission
    {
        return Permission::firstOrCreate(
            ['name' => $name],
            ['name' => $name]
        );
    }

    public function givePermissionToRole(string $roleName, string $permissionName): void
    {
        $role = Role::where('name', $roleName)->first();
        $permission = Permission::where('name', $permissionName)->first();

        if ($role && $permission) {
            $role->givePermissionTo($permission);
        }
    }
}

