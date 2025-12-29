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
    'middleware' => ['web','impersonate','XssSanitizer','auth'],
    'namespace' => 'Modules\Invoices\Http\Controllers'
], function () {
    Route::prefix('invoices')->group(function() {
        //Invoices
        Route::get('list', 'Main@index')->name('invoices.index');
        Route::get('taxes', 'Main@taxes')->name('invoices.taxes');
        Route::get('invoices/{invoice}/show', 'Main@show')->name('invoices.show');
        Route::get('invoices/{invoice}/edit', 'Main@edit')->name('invoices.edit');
        Route::get('create', 'Main@create')->name('invoices.create');
        Route::post('invoices', 'Main@store')->name('invoices.store');
        Route::put('invoices/{invoice}', 'Main@update')->name('invoices.update');
        Route::get('invoices/{invoice}/del', 'Main@destroy')->name('invoices.delete');
    });
});