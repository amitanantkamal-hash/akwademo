<?php

use Modules\Integrations\Http\Controllers\Main;

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
    'middleware' =>['web', 'impersonate', 'XssSanitizer', 'auth'],
    'namespace' => 'Modules\Integrations\Http\Controllers'
], function () {
    Route::prefix('integrations')->group(function() {
        Route::get('/', 'Main@index')->name('integrations.index');
    });
});
