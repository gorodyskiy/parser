<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::any('*', function () {
        return response()->json([
            'success' => false,
            'message' => 'Verify email.',
        ], 401);
    })->name('verification.notice');
    Route::any('*', function () {
        return response()->json([
            'success' => true,
            'message' => 'Login via API or use token.',
        ], 200);
    })->name('login');

    Route::post('register', [AuthController::class, 'register'])
        ->name('user.register');
    Route::post('login', [AuthController::class, 'login'])
        ->name('user.login');
    Route::get('/email/resend', [AuthController::class, 'resend'])
        ->name('verification.resend');
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])
        ->name('verification.verify');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::post('/price/subscribe', [PriceController::class, 'subscribe'])
        ->name('price.subscribe');
    Route::post('/price/unsubscribe', [PriceController::class, 'unsubscribe'])
        ->name('price.unsubscribe');

    Route::post('logout', [AuthController::class, 'logout'])
        ->name('user.logout');
    Route::delete('/user/', [UserController::class, 'delete'])
        ->name('user.delete');
});
