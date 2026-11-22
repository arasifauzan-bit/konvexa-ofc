<?php

use App\Http\Controllers\Api\OrderTrackingSyncController;
use App\Http\Middleware\VerifyKonvexaTrackingToken;
use Illuminate\Support\Facades\Route;

Route::post('/integrations/order-tracking', [OrderTrackingSyncController::class, 'store'])
    ->middleware(VerifyKonvexaTrackingToken::class)
    ->name('integrations.order-tracking.store');
