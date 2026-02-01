<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Pos\PosSyncController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Test route (remove after testing)
Route::get('/test', function () {
    return response()->json([
        'message' => 'API routes are working!',
        'timestamp' => now()->toDateTimeString()
    ]);
});

// Public auth routes
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {

    // Get current user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/logout-all', [AuthController::class, 'logoutAll']);
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
    });

    // POS Sync routes (for Electron app)
    Route::prefix('pos/sync')->group(function () {
        // Health check
        Route::get('/status', [PosSyncController::class, 'healthCheck']);

        // Batch sync operations
        Route::post('/sales', [PosSyncController::class, 'syncSales']);

        // Pull data for offline cache
        Route::get('/products', [PosSyncController::class, 'getUpdatedProducts']);
        Route::get('/customers', [PosSyncController::class, 'getUpdatedCustomers']);
        Route::get('/categories', [PosSyncController::class, 'getCategories']);

        // Legacy sync endpoints (existing functionality)
        Route::post('/upload', [PosSyncController::class, 'upload']);
        Route::get('/pending', [PosSyncController::class, 'pending']);
        Route::post('/process', [PosSyncController::class, 'process']);
        Route::post('/retry', [PosSyncController::class, 'retry']);
    });
});
