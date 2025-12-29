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
    'namespace' => 'Modules\Staff\Http\Controllers'
],function() {
    Route::prefix('staff')->group(function() {
        Route::get('users', 'Main@index')->name('staff.index');
        Route::get('users/{user}', 'Main@show')->name('staff.show');
        Route::get('permissions', 'Main@permissions')->name('staff.permissions');
        Route::get('permissions/{permission}', 'Main@permission')->name('staff.permission');
        Route::get('roles', 'Main@roles')->name('staff.roles');
        Route::get('roles/{role}', 'Main@role')->name('staff.role');
    });
});
