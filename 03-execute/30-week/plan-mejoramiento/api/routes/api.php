<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BicycleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::get('/health', fn () => response()->json(['status' => 'ok', 'service' => 'bike-share-api']));
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::apiResource('users', UserController::class)->except(['destroy']);
    Route::apiResource('bicycles', BicycleController::class);
    Route::get('/rentals/overdue', [RentalController::class, 'overdue']);
    Route::apiResource('rentals', RentalController::class)->only(['index', 'show', 'store']);
    Route::post('/rentals/{rental}/lines/{line}/return', [RentalController::class, 'returnLine']);
    Route::get('/reports/most-requested', [ReportController::class, 'mostRequested']);
});
