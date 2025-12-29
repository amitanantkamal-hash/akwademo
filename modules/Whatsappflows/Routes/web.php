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
    'middleware' =>[ 'web','impersonate','Modules\Wpbox\Http\Middleware\CheckPlan'],
    'namespace' => 'Modules\Whatsappflows\Http\Controllers'
], function () {
    Route::prefix('whatsapp-flows')->group(function() {

            Route::Any('/list', 'Main@index')->name('whatsapp-flows.index');
            Route::post('/', 'Main@store')->name('whatsapp-flows.store');
            Route::Any('/create', 'Main@create')->name('whatsapp-flows.create');
            Route::get('/load', 'Main@loadTemplates')->name('whatsapp-flows.load');
            Route::delete('/del/{flowid}', 'Main@destroy')->name('whatsapp-flows.destroy');
            Route::put('/edit/{flowid}', 'Main@edit')->name('whatsapp-flows.edit');
            Route::get('/publish/{flowid}', 'Main@publishflow')->name('whatsapp-flows.publish');
            Route::post('/deprecate/{flowid}', 'Main@deprecate')->name('whatsapp-flows.deprecate');
            Route::get('/viewdata/{flowid}', 'Main@createDataViewLayout')->name('whatsapp-flows.viewdata');
            
            Route::get('/submissions', 'Main@allSubmissions')->name('whatsapp-flows.submissions');
            Route::get('/whatsapp-submissions', 'Main@allSubmissions')->name('whatsapp.submissions');
            Route::get('/whatsapp/submissions/export', 'Main@exportSubmissions')->name('whatsapp.submissions.export');

            
    });

});