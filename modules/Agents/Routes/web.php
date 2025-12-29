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
use Modules\Agents\Http\Controllers\Main;

Route::group([
    'middleware' => ['web', 'impersonate','Modules\Wpbox\Http\Middleware\CheckPlan'],
    'namespace' => 'Modules\Agents\Http\Controllers'
], function () {
    Route::prefix('agent')->group(function () {
        Route::get('/list', [Main::class, 'index'])->name('agent.index');
        Route::get('/{agent}/edit', [Main::class, 'edit'])->name('agent.edit');
        Route::get('/create',  [Main::class, 'create'])->name('agent.create');
        Route::post('/', [Main::class, 'store'])->name('agent.store');
        Route::put('/{agent}', [Main::class, 'update'])->name('agent.update');
        Route::get('/del/{agent}',  [Main::class, 'destroy'])->name('agent.destroy');
        Route::get('/loginas/{agent}', [Main::class, 'loginas'])->name('agent.loginas');
        Route::get('/stop', [Main::class, 'stopImpersonate'])->name('owner.stopImpersonate');    
        Route::post('/{agent}/status', [Main::class, 'updateStatus'])->name('agent.status.update');
    });
});
