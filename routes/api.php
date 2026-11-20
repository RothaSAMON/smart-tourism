<?php

use App\Http\Controllers\Api\AttractionController;
use App\Http\Controllers\Api\AuthUserController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\BusinessController;
use App\Http\Controllers\Api\ItineraryController;
use App\Http\Controllers\Api\ItineraryItemController;
use App\Http\Middleware\CheckAuthStatus;
use Illuminate\Support\Facades\Route;

/*
* Public Routes
*/
Route::prefix('auth')->group(function (): void {
    Route::post('register', [AuthUserController::class, 'register']);
    Route::post('login', [AuthUserController::class, 'login']);
});

Route::apiResource('attractions', AttractionController::class)->only(['index', 'show']);
Route::apiResource('businesses', BusinessController::class)->only(['index', 'show']);

/*
* Protected Routes
* (Requires Passport Bearer Token & Active Status)
*/
Route::middleware(['auth:api', CheckAuthStatus::class])->group(function (): void {
    // User
    Route::put('update-password', [AuthUserController::class, 'updatePassword']);
    Route::put('update-me', [AuthUserController::class, 'updateAuthUser']);
    Route::get('me', [AuthUserController::class, 'authorizeUser']);
    Route::get('logout', [AuthUserController::class, 'logout']);

    // Tourism Write & Personal User Resources
    Route::apiResource('attractions', AttractionController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('businesses', BusinessController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('bookings', BookingController::class);
    Route::apiResource('itineraries', ItineraryController::class);
    Route::scopeBindings()->group(function (): void {
        Route::apiResource('itineraries.items', ItineraryItemController::class)
            ->only(['store', 'update', 'destroy']);
    });
});
