<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\ProductImageController;
use App\Http\Controllers\Inspection\InspectionController;
use App\Http\Controllers\Certification\CertificationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\InspectionController as AdminInspectionController;
use App\Http\Controllers\Admin\TradeInController;
use App\Http\Controllers\Admin\WarrantyController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TradeInController;
use App\Http\Controllers\ShippingController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    // OTP Routes
    Route::get('/otp/verify', [OtpController::class, 'showVerifyForm'])->name('otp.verify.form');
    Route::post('/otp/send', [OtpController::class, 'send'])->name('otp.send');
    Route::post('/otp/verify', [OtpController::class, 'verify'])->name('otp.verify');
});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Dashboard
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');
    
    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'showEdit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::get('/settings', [ProfileController::class, 'showSettings'])->name('settings');
        Route::post('/avatar', [ProfileController::class, 'uploadAvatar'])->name('avatar.upload');
        Route::post('/password', [ProfileController::class, 'changePassword'])->name('password.change');
    });

    // Product Routes
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/images', [ProductImageController::class, 'store'])->name('images.store');
    });

    // Inspection Routes
    Route::prefix('inspections')->name('inspections.')->group(function () {
        Route::post('/', [InspectionController::class, 'store'])->name('store');
        Route::post('/{id}/report', [InspectionController::class, 'submitReport'])->name('report.submit');
        Route::post('/{id}/images', [InspectionController::class, 'uploadImages'])->name('images.upload');
    });

    // Certification Routes
    Route::prefix('certifications')->name('certifications.')->group(function () {
        Route::post('/generate', [CertificationController::class, 'generate'])->name('generate');
        Route::get('/{id}', [CertificationController::class, 'show'])->name('show');
    });

    // Cart Routes
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/', [CartController::class, 'store'])->name('store');
        Route::put('/{id}', [CartController::class, 'update'])->name('update');
        Route::delete('/{id}', [CartController::class, 'destroy'])->name('destroy');
    });

    // Checkout Routes
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/', [CheckoutController::class, 'store'])->name('store');
    });

    // Order Routes
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{id}', [OrderController::class, 'show'])->name('show');
        Route::post('/{id}/cancel', [OrderController::class, 'cancel'])->name('cancel');
    });

    // Payment Routes
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::post('/', [PaymentController::class, 'store'])->name('store');
        Route::post('/{id}/confirm', [PaymentController::class, 'confirm'])->name('confirm');
        Route::post('/{id}/refund', [PaymentController::class, 'refund'])->name('refund');
        Route::get('/{id}/status', [PaymentController::class, 'status'])->name('status');
    });

    // Trade-in Routes
    Route::prefix('trade-in')->name('trade-in.')->group(function () {
        Route::get('/create', [TradeInController::class, 'create'])->name('create');
        Route::post('/', [TradeInController::class, 'store'])->name('store');
        Route::get('/', [TradeInController::class, 'index'])->name('index');
        Route::get('/{id}', [TradeInController::class, 'show'])->name('show');
    });

    // Shipping Routes
    Route::prefix('shipping')->name('shipping.')->group(function () {
        Route::get('/track/{trackingNumber}', [ShippingController::class, 'track'])->name('track');
        Route::get('/{id}', [ShippingController::class, 'show'])->name('show');
    });

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Users Management
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/{id}', [UserController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
        });

        // Products Management
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', [AdminProductController::class, 'index'])->name('index');
            Route::get('/{id}', [AdminProductController::class, 'show'])->name('show');
            Route::post('/{id}/approve', [AdminProductController::class, 'approve'])->name('approve');
            Route::post('/{id}/reject', [AdminProductController::class, 'reject'])->name('reject');
            Route::delete('/{id}', [AdminProductController::class, 'destroy'])->name('destroy');
        });

        // Inspections Management
        Route::prefix('inspections')->name('inspections.')->group(function () {
            Route::get('/', [AdminInspectionController::class, 'index'])->name('index');
            Route::get('/{id}', [AdminInspectionController::class, 'show'])->name('show');
            Route::post('/{id}/approve', [AdminInspectionController::class, 'approve'])->name('approve');
            Route::post('/{id}/reject', [AdminInspectionController::class, 'reject'])->name('reject');
        });

        // Orders Management
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/{id}', [OrderController::class, 'show'])->name('show');
            Route::put('/{id}/status', [OrderController::class, 'updateStatus'])->name('update-status');
            Route::get('/{id}/invoice', [OrderController::class, 'invoice'])->name('invoice');
            Route::delete('/{id}', [OrderController::class, 'destroy'])->name('destroy');
        });

        // Payments Management
        Route::prefix('payments')->name('payments.')->group(function () {
            Route::get('/', [PaymentController::class, 'index'])->name('index');
            Route::get('/{id}', [PaymentController::class, 'show'])->name('show');
            Route::post('/{id}/refund', [PaymentController::class, 'refund'])->name('refund');
        });

        // Trade-ins Management
        Route::prefix('trade-ins')->name('trade-ins.')->group(function () {
            Route::get('/', [TradeInController::class, 'index'])->name('index');
            Route::get('/{id}', [TradeInController::class, 'show'])->name('show');
            Route::post('/{id}/approve', [TradeInController::class, 'approve'])->name('approve');
            Route::post('/{id}/reject', [TradeInController::class, 'reject'])->name('reject');
        });

        // Warranties Management
        Route::prefix('warranties')->name('warranties.')->group(function () {
            Route::get('/', [WarrantyController::class, 'index'])->name('index');
            Route::get('/{id}', [WarrantyController::class, 'show'])->name('show');
            Route::put('/{id}/status', [WarrantyController::class, 'updateStatus'])->name('update-status');
        });

        // Shipping Management
        Route::prefix('shipping')->name('shipping.')->group(function () {
            Route::get('/', [ShippingController::class, 'index'])->name('index');
            Route::get('/{id}', [ShippingController::class, 'show'])->name('show');
            Route::put('/{id}/status', [ShippingController::class, 'updateStatus'])->name('update-status');
        });

        // Settings
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [SettingsController::class, 'index'])->name('index');
            Route::put('/', [SettingsController::class, 'update'])->name('update');
        });
    });
});

// Public Product Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
