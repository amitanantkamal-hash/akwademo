<?php

use Illuminate\Http\Request;
use Modules\LeadManager\Http\Controllers\LeadManagerController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:api', 'company'])->prefix('leads')->group(function () {
    Route::get('/', [LeadManagerController::class, 'index']);
    Route::post('/', [LeadManagerController::class, 'store']);
    Route::get('/kanban', [LeadManagerController::class, 'kanban']);
    Route::get('/{id}', [LeadManagerController::class, 'show']);
    Route::put('/{id}', [LeadManagerController::class, 'update']);
    Route::delete('/{id}', [LeadManagerController::class, 'destroy']);
    Route::put('/{id}/stage', [LeadManagerController::class, 'updateStage']);
    Route::post('/{id}/notes', [LeadManagerController::class, 'addNote']);
    Route::post('/{id}/followups', [LeadManagerController::class, 'scheduleFollowup']);
    Route::get('/export', [LeadManagerController::class, 'export']);
    Route::post('/bulk-action', [LeadManagerController::class, 'bulkAction']);
});