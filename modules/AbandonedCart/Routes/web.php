<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// routes/web.php

use Modules\AbandonedCart\Http\Controllers\AbandonedCartController;
use Modules\AbandonedCart\Http\Controllers\ShopifyAbandonedCartController;
use Modules\AbandonedCart\Http\Controllers\WooCommerceAbandonedCartController;

Route::prefix('abandoned-cart')->group(function () {
    Route::post('/shopify/webhook', [ShopifyAbandonedCartController::class, 'webhook']);
    Route::post('/woocommerce/webhook', [WooCommerceAbandonedCartController::class, 'webhook']);

    // Admin routes
    Route::middleware('auth')->group(function () {
        Route::get('/settings', [AbandonedCartController::class, 'settings'])->name('settings');
        Route::post('/settings', [AbandonedCartController::class, 'updateSettings'])->name('settings.update');
        Route::get('/', [AbandonedCartController::class, 'index'])->name('index');
        Route::get('/{id}', [AbandonedCartController::class, 'show'])->name('show');
        Route::post('/test', [AbandonedCartController::class, 'createTestAbandonedCart']); // routes/web.php
        Route::get('/test/connection', function () {
            return response()->json([
                'status' => 'success',
                'message' => 'Web server is working',
                'timestamp' => now(),
            ]);
        });
    });
});
