<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\ProductImageController;
use App\Http\Controllers\Inspection\InspectionController;
use App\Http\Controllers\Certification\CertificationController;
use Illuminate\Support\Facades\Route;

// Public API Routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [RegisterController::class, 'register'])->name('api.register');
    Route::post('/login', [LoginController::class, 'login'])->name('api.login');
    Route::post('/otp/send', [OtpController::class, 'send'])->name('api.otp.send');
    Route::post('/otp/verify', [OtpController::class, 'verify'])->name('api.otp.verify');
});

// Protected API Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [LoginController::class, 'logout'])->name('api.logout');
    
    Route::prefix('profile')->name('api.profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::post('/avatar', [ProfileController::class, 'uploadAvatar'])->name('avatar.upload');
        Route::post('/password', [ProfileController::class, 'changePassword'])->name('password.change');
    });

    // Product Routes
    Route::prefix('products')->name('api.products.')->group(function () {
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::put('/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/images', [ProductImageController::class, 'store'])->name('images.store');
    });

    // Inspection Routes
    Route::prefix('inspections')->name('api.inspections.')->group(function () {
        Route::post('/', [InspectionController::class, 'store'])->name('store');
        Route::post('/{id}/report', [InspectionController::class, 'submitReport'])->name('report.submit');
        Route::post('/{id}/images', [InspectionController::class, 'uploadImages'])->name('images.upload');
    });

    // Certification Routes
    Route::prefix('certifications')->name('api.certifications.')->group(function () {
        Route::post('/generate', [CertificationController::class, 'generate'])->name('generate');
    });
});

// Public Product Routes
Route::get('/products', [ProductController::class, 'index'])->name('api.products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('api.products.show');
Route::get('/certifications/{id}', [CertificationController::class, 'show'])->name('api.certifications.show');

