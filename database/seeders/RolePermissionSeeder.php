<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view products',
            'create products',
            'edit products',
            'delete products',
            'view orders',
            'create orders',
            'edit orders',
            'view inspections',
            'create inspections',
            'edit inspections',
            'view trade-ins',
            'create trade-ins',
            'approve trade-ins',
            'view users',
            'edit users',
            'delete users',
            'manage workshops',
            'manage content',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $buyerRole = Role::firstOrCreate(['name' => 'buyer']);
        $buyerRole->givePermissionTo([
            'view products',
            'create orders',
            'view orders',
            'create trade-ins',
            'view trade-ins',
        ]);

        $sellerRole = Role::firstOrCreate(['name' => 'seller']);
        $sellerRole->givePermissionTo([
            'view products',
            'create products',
            'edit products',
            'delete products',
            'view orders',
            'create inspections',
            'view inspections',
        ]);

        $workshopRole = Role::firstOrCreate(['name' => 'workshop']);
        $workshopRole->givePermissionTo([
            'view inspections',
            'create inspections',
            'edit inspections',
            'manage workshops',
        ]);

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());
    }
}

