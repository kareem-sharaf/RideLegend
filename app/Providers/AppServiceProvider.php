<?php

namespace App\Providers;

use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Infrastructure\Repositories\User\EloquentUserRepository;
use App\Infrastructure\Services\Otp\CacheOtpService;
use App\Infrastructure\Services\Otp\OtpServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Repository Bindings
        $this->app->bind(
            UserRepositoryInterface::class,
            EloquentUserRepository::class
        );

        // Service Bindings
        $this->app->bind(
            OtpServiceInterface::class,
            CacheOtpService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
