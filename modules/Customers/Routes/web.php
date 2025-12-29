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
    'namespace' => 'Modules\Customers\Http\Controllers',
    'middleware' => ['web', 'impersonate', 'auth', 'XssSanitizer']
], function () {
    Route::prefix('customers')->group(function() {
        Route::get('list', 'Main@index')->name('customers.index');
        Route::get('subscriptions', 'Main@subscriptions')->name('customers.subscriptions');
        Route::get('{customer}', 'Main@show')->name('customers.show');
        Route::get('subscriptions/{subscription}', 'Main@subscription')->name('customers.subscription');
    });
});
