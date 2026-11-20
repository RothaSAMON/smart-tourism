<?php

use App\Http\Controllers\Api\AttractionController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\BusinessController;
use App\Http\Controllers\Api\ItineraryController;
use App\Http\Controllers\Api\ItineraryItemController;
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
