<?php

use App\Http\Controllers\Api\AttractionController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\BusinessController;
use Illuminate\Support\Facades\Route;

// Public Tourism APIs
Route::apiResource('attractions', AttractionController::class);
Route::apiResource('businesses', BusinessController::class);
Route::apiResource('bookings', BookingController::class);
