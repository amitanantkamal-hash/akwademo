<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ConnectController;
use Modules\Catalogs\Http\Controllers\Catalogwebhook;
use App\Models\User;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/connect', [ConnectController::class, 'handleConnect']);

// Catalog
Route::any('catalogs/webhook', [Catalogwebhook::class, 'webhook'])
    ->name('Catalog.catalogsPaymentWebhook');

// Existing login routes
Route::post('/login', [LoginController::class, 'login']);
Route::post('/v2/login', [LoginController::class, 'login']);

// Connect route for CodeIgniter integration
