<?php

use Modules\SmartClick\Http\Controllers\SmartClickMonitorController;
use Modules\SmartClick\Http\Controllers\WhatsAppWebhookController;

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

Route::prefix('smartclick')->name('smartclick.')->group(function () {
    Route::get('/', [SmartClickMonitorController::class, 'index'])->name('index');
    Route::get('/create', [SmartClickMonitorController::class, 'create'])->name('create');
    Route::post('/', [SmartClickMonitorController::class, 'store'])->name('store');
    // Other routes...
});

// WhatsApp webhook route
Route::post('/whatsapp/webhook', [WhatsAppWebhookController::class, 'handleIncomingMessage']);
