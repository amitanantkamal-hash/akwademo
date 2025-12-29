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

use Modules\LeadManager\Http\Controllers\LeadManagerController;
use Illuminate\Support\Facades\Route;

// routes/web.php
Route::middleware(['auth'])->prefix('lead-manager')->name('leads.')->group(function () {
    Route::get('/', [LeadManagerController::class, 'index'])->name('index');
    Route::get('/create', [LeadManagerController::class, 'create'])->name('create');
    Route::post('/', [LeadManagerController::class, 'store'])->name('store');
    Route::get('/{id}', [LeadManagerController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [LeadManagerController::class, 'edit'])->name('edit');
    Route::put('/{id}', [LeadManagerController::class, 'update'])->name('update');
    Route::delete('/{id}', [LeadManagerController::class, 'destroy'])->name('destroy');
    Route::get('/kanban/view', [LeadManagerController::class, 'kanbanView'])->name('kanban');

    // Add these routes for notes and follow-ups
    Route::post('/{id}/notes', [LeadManagerController::class, 'addNote'])->name('notes.store');

    Route::put('/{id}/stage', [LeadManagerController::class, 'updateStage'])->name('stage.update');
    Route::post('/lead-sources/store', [LeadManagerController::class, 'storeLeadSource'])->name('lead-sources.store');
    // Follow-ups

    Route::post('/bulk-add-tag', [LeadManagerController::class, 'bulkAddTag'])->name('bulkAddTag');
    Route::post('/bulk-remove-tag', [LeadManagerController::class, 'bulkRemoveTag'])->name('bulkRemoveTag');
    Route::post('/bulk-add-group', [LeadManagerController::class, 'bulkAddGroup'])->name('bulkAddGroup');
    Route::post('/bulk-remove-group', [LeadManagerController::class, 'bulkRemoveGroup'])->name('bulkRemoveGroup');

    Route::post('/leads/{lead}/followups', [LeadManagerController::class, 'scheduleFollowup'])
        ->name('followups.store');
    // Follow-ups delete route
    Route::delete('/leads/{lead}/followups/{followup}', [LeadManagerController::class, 'destroyFollowup'])
        ->name('followups.destroy'); //

    Route::post('/lead-sources/update', [LeadManagerController::class, 'updateLeadSource'])->name('lead-sources.update');
    // Route::post('/lead-sources/store', [LeadManagerController::class, 'storeLeadSource'])->name('lead-sources.store');
    
    Route::post('/leads/{lead}/inline-update', [LeadManagerController::class, 'inlineUpdate'])->name('inlineUpdate');

    // Notes
    Route::delete('/leads/{lead}/notes/{note}', [LeadManagerController::class, 'destroyNotes'])->name('notes.destroy');
});
