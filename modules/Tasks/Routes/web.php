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

Route::group([
    'namespace' => 'Modules\Tasks\Http\Controllers',
    'middleware' => ['auth', 'web', 'XssSanitizer', 'impersonate']
], function() {
    Route::prefix('tasks')->group(function() {
        Route::get('list', 'Main@index')->name('tasks.index');
        Route::get('create', 'Main@index')->name('tasks.create');
        Route::post('', 'Main@index')->name('tasks.store');
        Route::get('{task}/edit', 'Main@index')->name('tasks.edit');
        Route::put('{task}', 'Main@index')->name('tasks.update');
        Route::delete('{task}', 'Main@index')->name('tasks.delete');
    });
});
