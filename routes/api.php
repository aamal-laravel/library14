<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ِِAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CheckoutController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('categories', [CategoryController::class, 'index']);
Route::get('category/{category}', [CategoryController::class, 'show']);
Route::apiResource('books', BookController::class)->only('index', 'show');
Route::apiResource('authors', AuthorController::class)->only('index', 'show');


Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('categories', [CategoryController::class, 'store']);
    Route::put('categories/{category}', [CategoryController::class, 'update']);
    Route::delete('categories/{category}', [CategoryController::class, 'destroy']);

    Route::apiResource('books', BookController::class)->except('index', 'show');
    Route::apiResource('authors', AuthorController::class)->except('index', 'show');
});

Route::middleware(['auth:sanctum', 'role:customer'])->group(function () {
    Route::put('customer/profile',     [CustomerController::class, 'update']);
    Route::get('customer/profile',     [CustomerController::class, 'show']);
    Route::post('checkout',[CheckoutController::class, 'store']);//from masa
});

Route::controller(ِِAuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('verify-otp', 'verifyOtp');
    Route::post('resend-otp', 'resendOtp');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});
//get , update settings
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('settings', [SettingController::class, 'index']);
    Route::put('settings', [SettingController::class, 'update']);
});
 //pay initial for testingg
 Route::middleware(['auth:sanctum'])
    ->group(function () {

        Route::post(
            'payments',
            [PaymentController::class, 'store']
        );

        Route::get(
            'payments/{payment}',
            [PaymentController::class, 'show']
        );
    });
    