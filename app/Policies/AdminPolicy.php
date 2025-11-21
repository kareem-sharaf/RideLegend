<?php

namespace App\Policies;

use App\Models\User;

class AdminPolicy
{
    /**
     * Determine if the user can access admin panel
     */
    public function accessAdmin(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can manage users
     */
    public function manageUsers(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can manage products
     */
    public function manageProducts(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can manage orders
     */
    public function manageOrders(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can manage payments
     */
    public function managePayments(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can manage inspections
     */
    public function manageInspections(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can manage trade-ins
     */
    public function manageTradeIns(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can manage warranties
     */
    public function manageWarranties(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can manage shipping
     */
    public function manageShipping(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can manage settings
     */
    public function manageSettings(User $user): bool
    {
        return $user->hasRole('admin');
    }
}

