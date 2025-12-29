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
use Modules\Contacts\Http\Controllers\Main;

Route::prefix('contacts')->group(function () {
    Route::get('/', 'ContactsController@index');
});

Route::group(
    [
        'middleware' => ['web', 'impersonate', 'XssSanitizer', 'auth', 'Modules\Wpbox\Http\Middleware\CheckPlan'],
        'namespace' => 'Modules\Contacts\Http\Controllers',
    ],
    function () {
        Route::prefix('contacts')->group(function () {
            //Contacts
            Route::get('manage', 'Main@index')->name('contacts.index');
            Route::get('manage/add', 'Main@indexAdd')->name('contacts.indexAdd');
            Route::get('manage/{contact}/edit', 'Main@edit')->name('contacts.edit');
            Route::get('manage/create', 'Main@create')->name('contacts.create');
            Route::get('manage/info/{id}', 'Main@indexContact')->name('contact.info');
            Route::post('manage', 'Main@store')->name('contacts.store');
            Route::post('manage/newContact', 'Main@storeContact')->name('contacts.storeContact');
            Route::post('manage/newlist', 'Main@storeList')->name('contacts.storlist');
            Route::put('manage/edit', 'Main@editList')->name('contacts.editList');
            Route::put('manage/{contact}', 'Main@update')->name('contacts.update');
            Route::get('manage/del/{contact}', 'Main@destroy')->name('contacts.delete');
            Route::get('manage/bulkremove/{contacts}', 'Main@bulkremove')->name('contacts.bulkremove');
            Route::get('manage/subscribe/{contacts}', 'Main@subscribe')->name('contacts.subscribe');
            Route::get('manage/unsubscribe/{contacts}', 'Main@unsubscribe')->name('contacts.unsubscribe');
            Route::get('manage/assigntogroup/{contacts}', 'Main@assigntogroup')->name('contacts.assigntogroup');
            Route::get('manage/removefromgroup/{contacts}', 'Main@removefromgroup')->name('contacts.removefromgroup');
            Route::post('manage/import/chunk', 'Main@importChunk')->name('contacts.import.chunk');
            Route::post('manage/convert-to-lead', [Main::class, 'convertToLead'])->name('contacts.convertToLead');

            Route::get('manage/togglesubs/{id}', 'Main@togglesubs')->name('contacts.toggle.sub');

            //Group
            //Group
            Route::get('groups', 'GroupsController@index')->name('contacts.groups.index');
            Route::get('groups/{group}/edit', 'GroupsController@edit')->name('contacts.groups.edit');
            Route::get('groups/create', 'GroupsController@create')->name('contacts.groups.create');
            Route::post('groups', 'GroupsController@store')->name('contacts.groups.store');
            Route::put('groups/{group}', 'GroupsController@update')->name('contacts.groups.update');
            Route::get('groups/del/{group}', 'GroupsController@destroy')->name('contacts.groups.delete');
            Route::delete('groups/{group}', 'GroupsController@destroy')->name('contacts.groups.delete');
            Route::delete('groups/delete-with-contacts/{group}', 'GroupsController@destroyWithContact')->name('contacts.groups.deleteWithContacts');

            //Field
            Route::get('fields', 'FieldsController@index')->name('contacts.fields.index');
            Route::get('fields/{id}/edit', 'FieldsController@edit')->name('contacts.fields.edit');
            Route::get('fields/create', 'FieldsController@create')->name('contacts.fields.create');
            Route::delete('fields/{field}', 'FieldsController@destroy')->name('contacts.fields.delete');
            Route::post('fields/add', 'Main@addField')->name('contacts.addField');
            Route::post('fields', 'FieldsController@store')->name('contacts.fields.store');
            Route::put('fields/{field}', 'FieldsController@update')->name('contacts.fields.update');
            Route::get('fields/del/{field}', 'FieldsController@destroy')->name('contacts.fields.delete');

            //Import
            Route::get('newimport', 'Main@newimportindex')->name('contacts.newimport.index');
            Route::get('import', 'Main@importindex')->name('contacts.import.index');
            Route::post('import', 'Main@import')->name('contacts.import.store');

            Route::post('read', 'Main@readDocument')->name('contacts.read');

            Route::get('datatable', 'Main@datatable')->name('contacts.datatable');
            Route::post('bulk-action', 'Main@bulkAction')->name('contacts.bulk.action');
            Route::delete('/contacts/{contact}', 'Main@destroy')->name('contacts.destroy');

            // Bulk Contact Actions
            Route::post('contacts/bulk-remove', [Main::class, 'bulkremove'])->name('contacts.bulk.remove');
            Route::post('contacts/bulk-subscribe', [Main::class, 'bulksubscribe'])->name('contacts.bulk.subscribe');
            Route::post('contacts/bulk-unsubscribe', [Main::class, 'bulkunsubscribe'])->name('contacts.bulk.unsubscribe');
            // Group Management Routes
            Route::post('contacts/assign-to-group', [Main::class, 'assigntogroup'])->name('contacts.assign-to-group');
            Route::post('contacts/remove-from-group', [Main::class, 'removefromgroup'])->name('contacts.remove-from-group');

            Route::get('/contacts/export', [Main::class, 'export'])->name('contacts.export');
            
            Route::get('/contacts/stats', [Main::class, 'getStats'])->name('contacts.stats');
        });
    },
);
