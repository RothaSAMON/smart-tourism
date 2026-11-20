<?php

use App\Http\Controllers\Api\AttractionController;
use App\Http\Controllers\Api\AuthUserController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\BusinessController;
use App\Http\Controllers\Api\ItineraryController;
use App\Http\Controllers\Api\ItineraryItemController;
use App\Http\Middleware\CheckAuthStatus;
use Illuminate\Support\Facades\Route;

// Public Tourism APIs
Route::apiResource('attractions', AttractionController::class);
Route::apiResource('businesses', BusinessController::class);
Route::apiResource('bookings', BookingController::class);
Route::apiResource('itineraries', ItineraryController::class);
Route::scopeBindings()->group(function (): void {
    Route::apiResource('itineraries.items', ItineraryItemController::class)
        ->only(['store', 'update', 'destroy']);
});


Route::middleware(['auth:api', CheckAuthStatus::class,])->group(function () {
    // User
    Route::put('update-password', [AuthUserController::class, 'updatePassword']);
    Route::put('update-me', [AuthUserController::class, 'updateAuthUser']);
    Route::get('me', [AuthUserController::class, 'authorizeUser']);
    Route::get('logout', [AuthUserController::class, 'logout']);
});


Route::prefix('auth')->group(function () {
    Route::post('register', [AuthUserController::class, 'register']);
    Route::post('login', [AuthUserController::class, 'login']);
    Route::post('user/login', [AuthUserController::class, 'loginUser']);
    Route::post('backend/login', [AuthUserController::class, 'loginBackend']);
});
