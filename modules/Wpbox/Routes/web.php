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

/* Route::prefix('wpbox')->group(function () {
    Route::get('/', 'WpboxController@index');
}); */

use Modules\WorkFlows\Http\Controllers\Main;
use Modules\Wpbox\Http\Controllers\MetaController;
use Illuminate\Support\Facades\Route;
use Modules\WorkFlows\Http\Controllers\WorkflowWebhookController;
use Modules\WorkFlows\Http\Controllers\WorkflowController;
use Modules\WorkFlows\Http\Controllers\WorkflowTaskController;
use Modules\Wpbox\Http\Controllers\RepliesController;
use Modules\Wpbox\Http\Controllers\TemplatesController;
use Modules\Wpbox\Http\Controllers\AutoRetargetController;

Route::prefix('api')->group(function () {
    Route::group(['prefix' => 'meta'], function () {
        Route::get('access-token/{code}', [MetaController::class, 'getAccessToken']);
        Route::get('exchange-token', [MetaController::class, 'exchangeShortToken']);
        Route::post('conversations', [MetaController::class, 'getConversations']);
        Route::post('messages', [MetaController::class, 'getMessages']);
        Route::post('send-message', [MetaController::class, 'sendMessage']);
        Route::post('receive-message', [MetaController::class, 'receiveMessage']);
        Route::get('handle-webhook', [MetaController::class, 'handleWebhook']);
        Route::post('register-page', [MetaController::class, 'connectPage']);
        Route::post('get-pages', [MetaController::class, 'getPages']);
        Route::post('logout/{socialMedia}', [MetaController::class, 'logout']);
    });
});

Route::group(
    [
        'middleware' => ['web', 'impersonate'],
        'namespace' => 'Modules\Wpbox\Http\Controllers',
    ],
    function () {
        Route::group(
            [
                'middleware' => ['verified', 'web', 'auth', 'otp.verified', 'impersonate', 'XssSanitizer', 'isOwnerOnPro', 'Modules\Wpbox\Http\Middleware\CheckPlan'],
            ],
            function () {
                //Chat
                Route::get('chat', 'ChatController@index')->name('chat.index');
                Route::get('chat-facebook', 'ChatController@facebook')->name('chat.facebook');
                Route::get('chat-instagram', 'ChatController@instagram')->name('chat.instagram');

                //Setup
                Route::get('whatsapp/setup', 'DashboardController@setup')->name('whatsapp.setup');
                Route::post('whatsapp/setup', 'DashboardController@savesetup')->name('whatsapp.store');

                Route::get('meta/setup/{socialMedia}', 'MetaController@setup')->name('meta.setup');
                // Route::get('instagram/setup', 'MetaController@instasetup')->name('instagram.setup');

                //Campaigns
                //Campaigns
                Route::get('campaigns', 'CampaignsController@index')->name('campaigns.index');
                Route::get('campaigns/{campaign}/show', 'CampaignsController@show')->name('campaigns.show');
                Route::get('campaigns/create', 'CampaignsController@create')->name('campaigns.create');
                Route::post('campaigns', 'CampaignsController@store')->name('campaigns.store');
                Route::put('campaigns/{campaign}', 'CampaignsController@update')->name('campaigns.update');
                // Route::get('campaigns/del/{campaign}', 'CampaignsController@destroy')->name('campaigns.delete');
                Route::delete('/campaigns/{id}', 'CampaignsController@destroy')->name('campaigns.delete');
                Route::post('campaigns/send-message', 'CampaignsController@MessageSendstore')->name('campaigns.MessageSendstore');
                Route::post('campaigns', 'CampaignsController@store')->name('campaigns.store');
                Route::put('campaigns/{campaign}', 'CampaignsController@update')->name('campaigns.update');
                Route::delete('campaigns/{campaign}', 'CampaignsController@destroys')->name('campaigns.deletes');

                //file manager
                Route::get('file-manager', 'FileManagerController@index')->name('file-manager.index');
                Route::post('file-manager', 'FileManagerController@store')->name('file-manager.store');
                Route::get('file-manager/load_files', 'FileManagerController@load_files')->name('file-manager.load_files');
                Route::get('file-manager/load_widget_files', 'FileManagerController@load_widget_files')->name('file-manager.load_widget_files');
                Route::get('file-manager/{id}/editor', 'FileManagerController@editor')->name('file-manager.editor');
                Route::post('file-manager/delete', 'FileManagerController@destroy')->name('file-manager.delete');
                Route::get('file-manager/{id}/requested_media_info', 'FileManagerController@requested_media_info')->name('file-manager.requested_media_info');
                Route::get('file-manager/popup/{type}', 'FileManagerController@popup')->name('file-manager.popup');
                Route::post('file-manager/load_selected_files', 'FileManagerController@load_selected_files')->name('file-manager.load_selected_files');
                Route::post('/file-manager/create-folder', 'FileManagerController@createFolder')->name('file-manager.create_folder'); //created by amit pawar 14-11-2025
                Route::get('/folder/{id}/files', 'FileManagerController@getFilesByFolder')->name('file-manager.folder_files'); //created by amit pawar 18-11-2025

                //Replies Button Template
                Route::get('button_template', 'RepliesButtonController@index')->name('button_template.index');
                Route::get('button_template/create', 'RepliesButtonController@create')->name('button_template.create');
                Route::post('button_template', 'RepliesButtonController@store')->name('button_template.store');
                Route::post('button_template/fetch_interactive', 'RepliesButtonController@fetch_interactive')->name('button_template.fetch_interactive');
                Route::post('button_template/ajax_list', 'RepliesButtonController@ajax_list')->name('button_template.ajax_list');
                Route::get('button_template/{button}/edit', 'RepliesButtonController@edit')->name('button_template.edit');
                Route::put('button_template/{button}', 'RepliesButtonController@update')->name('button_template.update');
                Route::delete('button_template/del/{button}', 'RepliesButtonController@destroy')->name('button_template.delete');

                //Replies Button Template
                Route::get('list_button_template', 'RepliesListButtonController@index')->name('list_button_template.index');
                Route::get('list_button_template/create', 'RepliesListButtonController@create')->name('list_button_template.create');
                Route::post('list_button_template/fetch_interactive', 'RepliesListButtonController@fetch_interactive')->name('list_button_template.fetch_interactive');
                Route::post('list_button_template/ajax_list', 'RepliesListButtonController@ajax_list')->name('list_button_template.ajax_list');
                Route::post('list_button_template', 'RepliesListButtonController@store')->name('list_button_template.store');
                Route::get('list_button_template/{button}/edit', 'RepliesListButtonController@edit')->name('list_button_template.edit');
                Route::put('list_button_template/{button}', 'RepliesListButtonController@update')->name('list_button_template.update');
                Route::delete('list_button_template/del/{button}', 'RepliesListButtonController@destroy')->name('list_button_template.delete');

                //Templates
                Route::get('templates', 'TemplatesController@index')->name('templates.index');
                Route::get('templates/create', 'TemplatesController@create')->name('templates.create');
                Route::post('templates/store', 'TemplatesController@store')->name('templates.store');
                Route::get('templates/load', 'TemplatesController@loadTemplates')->name('templates.load');
                Route::post('templates/submit', 'TemplatesController@submit')->name('templates.submit');
                Route::delete('templates/del/{template}', 'TemplatesController@destroy')->name('templates.destroy');
                Route::post('templates/upload-image', 'TemplatesController@uploadImage')->name('templates.upload-image');
                Route::post('templates/upload-video', 'TemplatesController@uploadVideo')->name('templates.upload-video');
                Route::post('templates/upload-pdf', 'TemplatesController@uploadPdf')->name('templates.upload-pdf');

                Route::get('/templates/search', [TemplatesController::class, 'search'])->name('templates.search');
                // Route::get('/contacts/search', [ContactController::class, 'search'])->name('contacts.search');
                // Route::get('/sources/search', [SourceController::class, 'search'])->name('sources.search');
                // Route::get('/groups/search', [GroupController::class, 'search'])->name('groups.search');
                // Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaigns.store');
                Route::post('/campaigns/store', 'CampaignsController@store')->name('campaigns.store');

                //Replies
                Route::get('replies', 'RepliesController@index')->name('replies.index');
                Route::get('replies/{reply}/edit', 'RepliesController@edit')->name('replies.edit');
                Route::get('replies/{id}/edit-ajax', 'RepliesController@editAjax')->name('replies.edit.ajax');
                Route::get('replies/create', 'RepliesController@create')->name('replies.create');
                Route::post('replies', 'RepliesController@store')->name('replies.store');
                Route::put('replies/{reply}', 'RepliesController@update')->name('replies.update');
                Route::delete('replies/del/{reply}', 'RepliesController@destroy')->name('replies.delete');
                Route::get('replies?type=qr', 'RepliesController@edit')->name('replies.quick');
                Route::post('replies/ajax_list', 'RepliesController@ajax_list')->name('replies.ajax_list');
                Route::post('/replies/{reply}/status', [RepliesController::class, 'updateStatus'])
    ->name('replies.status.update');

                // Edit routes
                Route::get('/{reply}/edit', [RepliesController::class, 'edit'])->name('edit');

                Route::get('/{id}/edit-ajax', [RepliesController::class, 'editAjax'])->name('edit-ajax');

                // Update route
                Route::put('/{reply}', [RepliesController::class, 'update'])->name('update');

                // Delete route
                Route::delete('/{reply}', [RepliesController::class, 'destroy'])->name('replies.destroy');

                //Deactivate and activate bot
                Route::get('campaigns/deactivatebot/{campaign}', 'CampaignsController@deactivateBot')->name('campaigns.deactivatebot');
                Route::get('campaigns/activatebot/{campaign}', 'CampaignsController@activateBot')->name('campaigns.activatebot');

                //Pause and resume campaign
                Route::get('campaigns/pause/{campaign}', 'CampaignsController@pause')->name('campaigns.pause');
                Route::get('campaigns/resume/{campaign}', 'CampaignsController@resume')->name('campaigns.resume');

                //Report
                Route::get('campaigns/report/{campaign}', 'CampaignsController@report')->name('campaigns.report');
                Route::post('/campaigns/report/{campaign}', 'CampaignsController@report')->name('campaigns.report');

                //Webhooks
                // Route::get('/workflows', [WorkFlowsController::class, 'index'])->name('workflow.index');
                // Route::get('/workflows/create', [WorkFlowsController::class, 'create'])->name('workflow.create');
                // Route::post('/workflows', [WorkFlowsController::class, 'store'])->name('workflow.store');
                // Route::get('/workflows/{id}/edit', [WorkFlowsController::class, 'edit'])->name('workflow.edit');
                // Route::put('/workflows/{id}', [WorkFlowsController::class, 'update'])->name('workflow.update');
                // Route::get('/workflows/{id}/logs', [WorkFlowsController::class, 'logs'])->name('workflow.logs');

                // Workflow Routes
                Route::get('/workflows', [WorkflowController::class, 'index'])->name('workflows.index');
                Route::get('/workflows/create', [WorkflowController::class, 'create'])->name('workflows.create');
                Route::post('/workflows', [WorkflowController::class, 'store'])->name('workflows.store');
                Route::get('/workflows/{workflow}/edit', [WorkflowController::class, 'edit'])->name('workflows.edit');
                Route::put('/workflows/{workflow}', [WorkflowController::class, 'update'])->name('workflows.update');
                Route::delete('/workflows/{workflow}', [WorkflowController::class, 'destroy'])->name('workflows.destroy');

                // Webhook Routes (For internal usage)
                Route::get('/workflow-webhooks', [WorkflowWebhookController::class, 'index'])->name('workflow_webhooks.index');
                Route::get('/workflow-webhooks/{workflow}', [WorkflowWebhookController::class, 'show'])->name('workflow_webhooks.show');

                // Task Routes
                Route::get('/workflow-tasks', [WorkflowTaskController::class, 'index'])->name('workflow_tasks.index');
                Route::get('/workflow-tasks/{workflow}', [WorkflowTaskController::class, 'show'])->name('workflow_tasks.show');
                Route::post('/workflow-tasks', [WorkflowTaskController::class, 'store'])->name('workflow_tasks.store');

                Route::get('/workflow-webhooks/{workflow}', [WorkflowWebhookController::class, 'fetchWebhookResponse'])->name('workflow-webhooks.fetch');
                
                // AutoRetarget Routes
                // AutoRetarget routes
                Route::prefix('autoretarget')->name('autoretarget.')->group(function () {
                    Route::get('/', [AutoRetargetController::class, 'index'])->name('index');
                    Route::get('/show', [AutoRetargetController::class, 'show'])->name('show');
                    Route::get('/edit/{id}', [AutoRetargetController::class, 'edit'])->name('edit');
                    Route::get('/create', [AutoRetargetController::class, 'create'])->name('create');
                    Route::post('/', [AutoRetargetController::class, 'store'])->name('store');
                    Route::get('/{autoretargetCampaign}/edit', [AutoRetargetController::class, 'edit'])->name('edit');
                    Route::put('/{autoretargetCampaign}', [AutoRetargetController::class, 'update'])->name('update');
                    Route::delete('/{autoretargetCampaign}', [AutoRetargetController::class, 'destroy'])->name('destroy');
                    Route::post('/toggle-status/{campaign}', [AutoRetargetController::class, 'toggleStatus'])->name('toggleStatus');

                });

                Route::post('/campaigns/{campaign}/autoretarget/toggle', [AutoRetargetController::class, 'toggleStatus'])->name('campaigns.autoretarget.toggle');

                // If you prefer to use resource routing, you can use this instead:
                // Route::resource('autoretarget', App\Http\Controllers\AutoRetargetController::class);

                // Route::prefix('work-flows')->group(function () {
                //     Route::get('/', [WorkFlowsController::class, 'logs'])->name('webhooks.logs');
                // });

                //API

                Route::prefix('api/dotflo')->group(function () {
                    Route::get('campaings/apis', 'APIController@index')->name('wpbox.api.index');
                });

                Route::prefix('api/wpbox')->group(function () {
                    Route::get('me', 'APIController@me')->name('wpbox.api.me');
                    // Route::get('campaings/apis', 'APIController@index')->name('wpbox.api.index');
                    Route::get('info', 'APIController@info')->name('api.info');
                    Route::get('chats/{lastmessagetime}/{page?}/{search_query?}', 'ChatController@chatlist');
                    Route::get('chat/{contact}', 'ChatController@chatmessages');
                    Route::post('send/{contact}', 'ChatController@sendMessageToContact');
                    Route::post('sendnote/{contact}', 'ChatController@sendNoteToContact');
                    Route::post('sendimage/{contact}', 'ChatController@sendImageMessageToContact');
                    Route::post('sendfile/{contact}', 'ChatController@sendDocumentMessageToContact');
                    Route::post('assign/{contact}', 'ChatController@assignContact');
                    Route::post('setlanguage/{contact}', 'ChatController@setLanguage');
                    Route::post('updateContact', 'APIController@updateContact');
                    Route::post('updateAIBot', 'APIController@updateAIBot');
                    Route::post('addTagToContact', 'APIController@addTagToContact');
                    Route::post('removeTagFromContact', 'APIController@removeTagFromContact');
                    Route::post('addGroupToContact', 'APIController@addGroupToContact');
                    Route::post('removeGroupFromContact', 'APIController@removeGroupFromContact');
                    Route::post('sendaudio/{contact}', 'ChatController@sendAudio');
                    Route::get('contact-groups-and-custom-fields/{contact}', 'APIController@getContactGroupsAndCustomFields');
                    Route::get('notes/{contact}', 'APIController@getNotes');
                });
            },
        );

        //Webhook
        Route::prefix('webhook/wpbox')->group(function () {
            Route::post('receive/{token}', 'ChatController@receiveMessage');
            Route::get('receive/{tokenViaURL}', 'ChatController@verifyWebhook');
            Route::get('sendschuduledmessages', 'CampaignsController@sendSchuduledMessages');
        });

        Route::group(
            [
                'middleware' => ['Modules\Wpbox\Http\Middleware\CheckAPIPlan'],
            ],
            function () {
                //PUBLIC API
                Route::prefix('api/wpbox')->group(function () {
                    Route::post('sendtemplatemessage', 'APIController@sendTemplateMessageToPhoneNumber');
                    Route::post('sendmessage', 'APIController@sendMessageToPhoneNumber');
                    Route::get('getTemplates', 'APIController@getTemplates');
                    Route::get('getGroups', 'APIController@getGroups');
                    Route::post('sendlistmessage', 'APIController@sendListMessageToPhoneNumber');

                    //getCampaigns
                    Route::get('getCampaigns', 'APIController@getCampaigns');
                    Route::get('getContacts', 'APIController@getContacts');
                    Route::post('makeContact', 'APIController@contactApiMake');
                    Route::post('updateContact', 'APIController@contactApiUpdate');
                    Route::post('sendcampaigns', 'APIController@sendCampaignMessageToPhoneNumber');

                    //getSingleContact
                    Route::get('getSingleContact', 'APIController@getSingleContact');

                    //Mobile App
                    Route::post('getConversations/{lastmessagetime}', 'APIController@getConversations');
                    Route::post('getMessages', 'APIController@getMessages');
                });
            },
        );
    },
);
