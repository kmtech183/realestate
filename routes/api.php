<?php

use App\Http\Controllers\Api\V1\PropertyApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware(['throttle:60,1'])->group(function () {
    // Public Property Catalog API
    Route::get('/properties', [PropertyApiController::class, 'index']);
    Route::get('/properties/{property:slug}', [PropertyApiController::class, 'show']);
    Route::get('/categories', [PropertyApiController::class, 'categories']);
    Route::get('/market-stats', [PropertyApiController::class, 'marketStats']);
});
