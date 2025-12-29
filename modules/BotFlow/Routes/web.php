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

use Illuminate\Support\Facades\Route;

use Modules\BotFlow\Http\Controllers\BotFlowController;
use Modules\BotFlow\Http\Livewire\FlowBot\FlowList;

Route::prefix('/')->group(function () {
    Route::get('/bot-flow-list', FlowList::class)->name('bot-flow-list');
    Route::get('bot-flows/edit/{id}', [BotFlowController::class, 'edit'])->name('bot-flows.edit');
    Route::post('bot-flows/save', [BotFlowController::class, 'saveBotFlow'])->name('bot-flows.save');
    Route::get('/get-bot-flow/{id}', [BotFlowController::class, 'get']);
    Route::post('/save-bot-flow', [BotFlowController::class, 'save']);
    Route::get('/whatsapp-templates', [BotFlowController::class, 'getTemplates']);
    Route::post('/upload-media', [BotFlowController::class, 'upload']);
});
