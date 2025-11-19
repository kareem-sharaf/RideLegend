<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\User\ProfileController;
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
});

