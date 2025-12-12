<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::prefix('v1')->group(function () {
    // Auth
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/auth/me', [AuthController::class, 'me']);
        
        // Organizer Routes
        Route::apiResource('organizer/events', \App\Http\Controllers\Api\OrganizerEventController::class);
        Route::get('organizer/analytics', [\App\Http\Controllers\Api\AnalyticsController::class, 'organizerStats']);
        Route::apiResource('organizer/team', \App\Http\Controllers\Api\TeamController::class);
        
        // Checkout & Orders
        Route::post('/checkout', [\App\Http\Controllers\Api\CheckoutController::class, 'store']);
        Route::get('/my-orders', [\App\Http\Controllers\Api\CheckoutController::class, 'myOrders']);
    });

    // Public Events
    Route::get('/events', [\App\Http\Controllers\Api\EventController::class, 'index']);
    Route::get('/events/{slug}', [\App\Http\Controllers\Api\EventController::class, 'show']);
});
