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

// app/Modules/CTWAMeta/Routes/web.php

use Illuminate\Support\Facades\Route;

use Modules\CTWAMeta\Http\Controllers\CTWAMetaController;
use Modules\CTWAMeta\Http\Controllers\FacebookFormController;
use Modules\CTWAMeta\Services\MetaApiService;
use Modules\CTWAMeta\Http\Controllers\MetaWebhookController;
use Modules\CTWAMeta\Http\Controllers\CTWAController;

Route::middleware(['web', 'auth','Modules\Wpbox\Http\Middleware\CheckPlan'])->group(function () {
    Route::prefix('ctwameta')->group(function () {
        Route::get('/', [CTWAMetaController::class, 'index'])->name('ctwameta.index');
        Route::get('/connect', [CTWAMetaController::class, 'connect'])->name('ctwameta.connect');
        Route::get('/callback', [CTWAMetaController::class, 'callback'])->name('ctwameta.callback');
        Route::get('/refresh', [CTWAMetaController::class, 'refreshAccounts'])->name('ctwameta.refresh');
        Route::get('/analytics/{accountId}', [CTWAMetaController::class, 'analytics'])->name('ctwameta.analytics');
        Route::post('/meta/subscribe', [CTWAMetaController::class, 'toggleSubscription'])->name('meta.subscribe');

        // Facebook Lead Forms
        Route::get('/{page_id}/forms', [FacebookFormController::class, 'index'])->name('facebook.manage.forms');
        Route::post('/{page_id}/{company_id}/forms/fetch', [FacebookFormController::class, 'fetchForms'])->name('facebook.forms.fetchAll');
        Route::post('/forms/{form_id}/webhook', [FacebookFormController::class, 'setWebhook'])->name('facebook.forms.webhook');
        Route::delete('/facebook/forms/{formId}/webhook', [FacebookFormController::class, 'removeWebhook'])->name('facebook.forms.removeWebhook');
        // Subscription management
    });
    Route::get('/facebook/pages/{pageId}/leads', [CTWAMetaController::class, 'viewLeads'])->name('facebook.pages.leads');
    Route::post('/facebook/pages/{pageId}/fetch-leads', [CTWAMetaController::class, 'fetchLeads']);

    Route::post('/delete-business', [CTWAMetaController::class, 'deleteBusiness'])->name('ctwameta.delete-business');

    // Delete Facebook Page
    Route::post('/delete-page', [CTWAMetaController::class, 'deletePage'])->name('ctwameta.delete-page');
    Route::post('/delete-business', [CTWAMetaController::class, 'deleteBusiness'])->name('ctwameta.delete-business');

    Route::get('/debug/fb-config', function () {
        return [
            'app_id' => config('services.facebook.client_id'),
            'app_id_valid' => is_numeric(config('services.facebook.client_id')),
            'app_id_length' => strlen(config('services.facebook.client_id')),
            'redirect_uri' => route('ctwameta.callback'),
        ];
    });

    Route::get('/test-fb-url', function () {
        $params = [
            'client_id' => config('services.facebook.client_id'),
            'redirect_uri' => config('services.facebook.redirect'),
            'state' => 'teststate123',
            'scope' => 'business_management,ads_management',
        ];

        return 'https://www.facebook.com/v18.0/dialog/oauth?' . http_build_query($params);
    });

    Route::get('/test-token-exchange', function () {
        try {
            $service = app(MetaApiService::class);

            // Simulate a callback with a test code
            $token = $service->getAccessTokenFromCode('test_code', 'https://bluai.in/ctwameta/callback');

            return [
                'short_lived' => (string) $token,
                'long_lived' => $service->getLongLivedToken($token),
            ];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    });

    Route::get('/test-session', function () {
        session(['test_key' => 'test_value']);
        return session('test_key'); // Should return "test_value"
    });

    Route::get('/test-handler', function () {
        $service = app(MetaApiService::class);
        return get_class($service->getFacebook()->getPersistentDataHandler());
        // Should return your LaravelPersistentDataHandler class
    });
});

// Webhook route (no auth middleware)
// Route::prefix('webhooks')->group(function() {
//     Route::post('meta/lead', [MetaWebhookController::class, 'handleLead'])
//         ->name('ctwameta.webhooks.lead');
// });

// Option 2: Secret-based (more secure - recommended)
// Route::post('webhooks/meta/lead', [MetaWebhookController::class, 'handleLead'])
//     ->name('ctwameta.webhooks.lead');

// Route::match(['get', 'post'], 'webhooks/meta/lead', [MetaWebhookController::class, 'handleLead'])->name('ctwameta.webhooks.lead');
Route::prefix('webhooks')->group(function () {
    Route::post('receive/{token}', 'ChatController@receiveMessage');
    Route::get('meta/lead/{tokenViaURL}', 'MetaWebhookController@verifyLeadWebhook');
    Route::get('sendschuduledmessages', 'CampaignsController@sendSchuduledMessages');
});

Route::match(['get', 'post'], 'webhooks/meta/lead', [MetaWebhookController::class, 'handleLead'])->name('ctwameta.webhooks.lead');

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Route::post('webhooks/meta/test', function (Request $request) {
    \Log::info('TEST webhook hit!', ['data' => $request->all()]);
    return response()->json(['status' => 'ok']);
});

    //CTWA
    Route::get('/ctwa', [CTWAController::class, 'index'])->name('ctwa.index');
    Route::get('/ctwa/create_ads', [CTWAController::class, 'create_ads'])->name('ctwa.create_ads');
    Route::get('/meta/countries', [CTWAController::class, 'getCountries']);
    Route::get('/meta/locations', [CTWAController::class, 'getLocations']);
    Route::get('/meta/meta-interests', [CTWAController::class, 'searchMetaInterests']);
    Route::get('/meta/pages', [CTWAController::class, 'getUserPages']);
    Route::post('/meta/page-profile', [CTWAController::class, 'getMetaProfileFromSelection']);
    Route::get('/meta/ad-accounts', [CTWAController::class, 'getMetaAdAccounts']);
    Route::post('/meta/ads/create', [CTWAController::class, 'submitCtwaAd'])->name('ctwa.create');
    Route::get('/ctwa/fetch-ads', [CtwaController::class, 'fetchAds'])->name('ctwa.fetch_ads');
    Route::get('/ctwa/fetch-store', [CtwaController::class, 'fetchAndStoreAds'])->name('ctwa.fetch_store_ads');
    Route::get('/ad-details/{adId}', [CtwaController::class, 'show'])->name('ad.details');
    Route::get('/ads/{ad}', [CtwaController::class, 'show'])->name('ads.show');
    Route::get('/leads/filter', [CtwaController::class, 'filter']);
    Route::post('/campaigns/send', [CtwaController::class, 'sendCampaign'])->name('campaign.send');