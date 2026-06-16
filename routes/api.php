<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ِِAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('categories', [CategoryController::class, 'index']);
Route::get('category/{category}', [CategoryController::class, 'show']);
Route::apiResource('books', BookController::class)->only('index', 'show');


Route::middleware(['auth:sanctum', 'user-type:admin'])->group(function () {
    Route::post('categories', [CategoryController::class, 'store']);
    Route::put('categories/{category}', [CategoryController::class, 'update']);
    Route::delete('categories/{category}', [CategoryController::class, 'destroy']);

    Route::apiResource('books', BookController::class)->except('index', 'show');

});

Route::middleware(['auth:sanctum', 'user-type:customer'])->group(function () {
    Route::put('customer/profile',     [CustomerController::class, 'update']);
    Route::get('customer/profile',     [CustomerController::class, 'show']);
});

Route::controller(ِِAuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('verify-otp', 'verifyOtp');
    Route::post('resend-otp', 'resendOtp');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});
