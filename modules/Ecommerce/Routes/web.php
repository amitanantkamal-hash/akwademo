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
use Modules\Ecommerce\Http\Controllers\Main;

Route::group([
    'middleware' => ['web', 'impersonate'],
    'namespace' => 'Modules\Ecommerce\Http\Controllers'
], function () {
    Route::prefix('tienda')->group(function() {
        Route::get('/', [Main::class, 'index'])->name('tienda.index');
        Route::get('productos', 'Modules\Ecommerce\Http\Controllers\ProductController@index')->name('productos.index');
        Route::get('categorias', 'Modules\Ecommerce\Http\Controllers\CategoriaController@index')->name('categorias.index');
        Route::get('ajustes', 'Modules\Ecommerce\Http\Controllers\AjustesController@index')->name('ajustes.index');
    });
});




