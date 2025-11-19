<?php

namespace App\Providers;

use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\Product\Repositories\ProductRepositoryInterface;
use App\Domain\Inspection\Repositories\InspectionRepositoryInterface;
use App\Domain\Certification\Repositories\CertificationRepositoryInterface;
use App\Infrastructure\Repositories\User\EloquentUserRepository;
use App\Infrastructure\Repositories\Product\EloquentProductRepository;
use App\Infrastructure\Repositories\Inspection\EloquentInspectionRepository;
use App\Infrastructure\Repositories\Certification\EloquentCertificationRepository;
use App\Infrastructure\Services\Otp\CacheOtpService;
use App\Infrastructure\Services\Otp\OtpServiceInterface;
use App\Infrastructure\Services\ProductImage\ProductImageServiceInterface;
use App\Infrastructure\Services\ProductImage\LocalStorageProductImageService;
use App\Infrastructure\Services\InspectionImage\InspectionImageServiceInterface;
use App\Infrastructure\Services\InspectionImage\LocalStorageInspectionImageService;
use App\Infrastructure\Services\InspectionReport\InspectionReportPdfServiceInterface;
use App\Infrastructure\Services\InspectionReport\DomPdfInspectionReportService;
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

        // Repository Bindings
        $this->app->bind(
            ProductRepositoryInterface::class,
            EloquentProductRepository::class
        );

        $this->app->bind(
            InspectionRepositoryInterface::class,
            EloquentInspectionRepository::class
        );

        $this->app->bind(
            CertificationRepositoryInterface::class,
            EloquentCertificationRepository::class
        );

        // Service Bindings
        $this->app->bind(
            ProductImageServiceInterface::class,
            LocalStorageProductImageService::class
        );

        $this->app->bind(
            InspectionImageServiceInterface::class,
            LocalStorageInspectionImageService::class
        );

        $this->app->bind(
            InspectionReportPdfServiceInterface::class,
            DomPdfInspectionReportService::class
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
