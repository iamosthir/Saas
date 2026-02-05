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

    Route::get('/get-product-list',"ProductController@getList");



    // POS System Routes (requires pos permission)
    Route::group(['prefix' => 'pos', 'namespace' => 'Pos'], function() {
        // Initialize
        Route::get('/initialize', 'PosController@initialize');

        // Products
        Route::get('/products/search', 'ApiPosProductController@search');
        Route::get('/products/popular', 'ApiPosProductController@popular');
        Route::get('/products/barcode/{barcode}', 'ApiPosProductController@scanBarcode');
        Route::get('/products/category/{categoryId}', 'ApiPosProductController@byCategory');
        Route::get('/products/{id}', 'ApiPosProductController@show');
        Route::get('/products/{id}/stock', 'ApiPosProductController@checkStock');

        // Sales
        Route::get('/sales', 'ApiPosSaleController@index');
        Route::post('/sales', 'ApiPosSaleController@store');
        Route::get('/sales/parked', 'ApiPosSaleController@getParkedSales');
        Route::get('/sales/drafts', 'ApiPosSaleController@getDrafts');
        Route::get('/sales/{id}', 'ApiPosSaleController@show');
        Route::put('/sales/{id}', 'ApiPosSaleController@update');
        Route::delete('/sales/{id}', 'ApiPosSaleController@destroy');
        Route::post('/sales/{id}/items', 'ApiPosSaleController@addItem');
        Route::put('/sales/{saleId}/items/{itemId}', 'ApiPosSaleController@updateItem');
        Route::delete('/sales/{saleId}/items/{itemId}', 'ApiPosSaleController@removeItem');
        Route::post('/sales/{id}/complete', 'ApiPosSaleController@complete');
        Route::post('/sales/{id}/park', 'ApiPosSaleController@park');
        Route::post('/sales/{id}/unpark', 'ApiPosSaleController@unpark');
        Route::post('/sales/{id}/void', 'ApiPosSaleController@void');

        // Refunds
        Route::get('/sales/{id}/refundable-items', 'ApiPosSaleController@getRefundableItems');
        Route::post('/sales/{id}/refund-full', 'ApiPosSaleController@refundFull');
        Route::post('/sales/{id}/refund-partial', 'ApiPosSaleController@refundPartial');

        // Payments
        Route::post('/payments', 'ApiPosPaymentController@process');
        Route::get('/payments/{saleId}/summary', 'ApiPosPaymentController@summary');
        Route::get('/payments/{saleId}/quick-amounts', 'ApiPosPaymentController@quickAmounts');

        // Customers
        Route::get('/customers', 'ApiPosCustomerController@index');
        Route::post('/customers', 'ApiPosCustomerController@store');
        Route::get('/customers/find-by-phone', 'ApiPosCustomerController@findByPhone');
        Route::get('/customers/{id}', 'ApiPosCustomerController@show');
        Route::get('/customers/{id}/history', 'ApiPosCustomerController@purchaseHistory');

        // Inventory
        Route::post('/inventory/adjust', 'ApiPosInventoryController@adjust');
        Route::get('/inventory/movements', 'ApiPosInventoryController@movements');
        Route::get('/inventory/low-stock', 'ApiPosInventoryController@lowStock');
        Route::get('/inventory/{productId}/stock', 'ApiPosInventoryController@stockLevel');

        // Settings
        Route::get('/settings', 'PosSettingsController@show');
        Route::put('/settings', 'PosSettingsController@update');
        Route::post('/settings/reset', 'PosSettingsController@reset');

        // Sync (Offline)
        Route::post('/sync/upload', 'PosSyncController@upload');
        Route::get('/sync/pending', 'PosSyncController@pending');
        Route::post('/sync/process', 'PosSyncController@process');
        Route::post('/sync/retry', 'PosSyncController@retry');
        Route::get('/sync/status', 'PosSyncController@status');

        // Print
        Route::get('/print/{saleId}/receipt', 'PosPrintController@receipt');
        Route::get('/print/{saleId}/escpos', 'PosPrintController@escpos');
        Route::get('/print/{saleId}/html', 'PosPrintController@html');
        Route::get('/print/{saleId}', 'PosPrintController@print');
        Route::post('/print/{saleId}/whatsapp', 'PosPrintController@sendWhatsApp');
        Route::get('/print/whatsapp/status', 'PosPrintController@whatsappStatus');
    });
    // End POS

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
