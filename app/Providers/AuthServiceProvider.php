<?php

namespace App\Providers;

use App\Policies\AdminPolicy;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => AdminPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Define gates for admin access
        \Gate::define('access-admin', function (User $user) {
            return $user->hasRole('admin');
        });

        \Gate::define('manage-users', function (User $user) {
            return $user->hasRole('admin');
        });

        \Gate::define('manage-products', function (User $user) {
            return $user->hasRole('admin');
        });

        \Gate::define('manage-orders', function (User $user) {
            return $user->hasRole('admin');
        });

        \Gate::define('manage-payments', function (User $user) {
            return $user->hasRole('admin');
        });

        \Gate::define('manage-inspections', function (User $user) {
            return $user->hasRole('admin');
        });

        \Gate::define('manage-trade-ins', function (User $user) {
            return $user->hasRole('admin');
        });

        \Gate::define('manage-warranties', function (User $user) {
            return $user->hasRole('admin');
        });

        \Gate::define('manage-shipping', function (User $user) {
            return $user->hasRole('admin');
        });

        \Gate::define('manage-settings', function (User $user) {
            return $user->hasRole('admin');
        });
    }
}

