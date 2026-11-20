<?php

use App\Http\Controllers\Api\AttractionController;
use Illuminate\Support\Facades\Route;

// Public Attraction APIs
Route::apiResource('attractions', AttractionController::class);
