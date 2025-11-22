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
use App\Domain\Cart\Repositories\CartRepositoryInterface;
use App\Domain\Order\Repositories\OrderRepositoryInterface;
use App\Domain\Payment\Repositories\PaymentRepositoryInterface;
use App\Domain\TradeIn\Repositories\TradeInRepositoryInterface;
use App\Domain\Shipping\Repositories\ShippingRepositoryInterface;
use App\Domain\Warranty\Repositories\WarrantyRepositoryInterface;
use App\Infrastructure\Repositories\Cart\EloquentCartRepository;
use App\Infrastructure\Repositories\Order\EloquentOrderRepository;
use App\Infrastructure\Repositories\Payment\EloquentPaymentRepository;
use App\Infrastructure\Repositories\TradeIn\EloquentTradeInRepository;
use App\Infrastructure\Repositories\Shipping\EloquentShippingRepository;
use App\Infrastructure\Repositories\Warranty\EloquentWarrantyRepository;
use App\Infrastructure\Services\Payments\PaymentServiceFactory;
use App\Infrastructure\Services\Payments\StripeService;
use App\Infrastructure\Services\Payments\PayPalService;
use App\Infrastructure\Services\Payments\LocalGatewayService;
use App\Infrastructure\Services\Shipping\ShippingServiceFactory;
use App\Infrastructure\Services\Shipping\DHLService;
use App\Infrastructure\Services\Shipping\AramexService;
use App\Infrastructure\Services\Shipping\LocalCourierService;
use App\Infrastructure\Services\Export\ExportServiceInterface;
use App\Infrastructure\Services\Export\CsvExportService;
use App\Infrastructure\Services\Export\PdfExportService;
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

        // Phase 7: Commerce Repositories
        $this->app->bind(
            CartRepositoryInterface::class,
            EloquentCartRepository::class
        );

        $this->app->bind(
            OrderRepositoryInterface::class,
            EloquentOrderRepository::class
        );

        $this->app->bind(
            PaymentRepositoryInterface::class,
            EloquentPaymentRepository::class
        );

        $this->app->bind(
            TradeInRepositoryInterface::class,
            EloquentTradeInRepository::class
        );

        $this->app->bind(
            ShippingRepositoryInterface::class,
            EloquentShippingRepository::class
        );

        $this->app->bind(
            WarrantyRepositoryInterface::class,
            EloquentWarrantyRepository::class
        );

        // Payment Services
        $this->app->singleton(StripeService::class, function ($app) {
            return new StripeService();
        });

        $this->app->singleton(PayPalService::class, function ($app) {
            return new PayPalService();
        });

        $this->app->singleton(LocalGatewayService::class, function ($app) {
            return new LocalGatewayService();
        });

        $this->app->singleton(PaymentServiceFactory::class, function ($app) {
            return new PaymentServiceFactory(
                $app->make(StripeService::class),
                $app->make(PayPalService::class),
                $app->make(LocalGatewayService::class)
            );
        });

        // Shipping Services
        $this->app->singleton(DHLService::class, function ($app) {
            return new DHLService();
        });

        $this->app->singleton(AramexService::class, function ($app) {
            return new AramexService();
        });

        $this->app->singleton(LocalCourierService::class, function ($app) {
            return new LocalCourierService();
        });

        $this->app->singleton(ShippingServiceFactory::class, function ($app) {
            return new ShippingServiceFactory(
                $app->make(DHLService::class),
                $app->make(AramexService::class),
                $app->make(LocalCourierService::class)
            );
        });

        // Export Services
        $this->app->bind(ExportServiceInterface::class, function ($app) {
            return $app->make(CsvExportService::class);
        });

        $this->app->singleton(CsvExportService::class);
        $this->app->singleton(PdfExportService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
