<?php

use App\Http\Controllers\AppsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\OtpController;
use App\Http\Middleware\SubscriptionMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\registerController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\CreditsController;
use App\Http\Controllers\CRUD\PostsController;
use App\Http\Controllers\Auth\SocialController;
use Spatie\WelcomeNotification\WelcomesNewUsers;
use App\Http\Controllers\Auth\MyWelcomeController;
use App\Http\Controllers\Auth\TokenLoginController;
use App\Http\Controllers\Auth\VerifyPendingUserController;
use App\Http\Controllers\HubSpotController;
use App\Http\Controllers\SubscriptionController;
use Laravel\Cashier\Subscription;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|w
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/login-via-token/{token}', [TokenLoginController::class, 'login'])
    ->name('login.via.token');

Route::get('/register', function () {
    return view('auth.register'); // your register page
})->name('register');

Route::get('login-activity', [LoginController::class, 'loginActivity'])->middleware('auth:sanctum');

Route::post('register', [RegisteredUserController::class, 'store'])->name('register.store');

Route::get('/verify-email/{token}', [VerifyPendingUserController::class, 'verify'])->name('pending.verify');

Route::get('/', [FrontEndController::class, 'index'])->name('landing');
Route::get('/new', [FrontEndController::class, 'register'])->name('newcompany.register');
Route::get('/' . config('settings.url_route', 'company') . '/{alias}', [FrontEndController::class, 'company'])->name('vendor');
Route::get('/notify/{type}/{id}/{message}', [CompaniesController::class, 'notify'])->name('company.notify');
Route::middleware('web', WelcomesNewUsers::class)->group(function () {
    Route::get('welcome/{user}', [MyWelcomeController::class, 'showWelcomeForm'])->name('welcome');
    Route::post('welcome/{user}', [MyWelcomeController::class, 'savePassword']);
});
Route::middleware(['web', 'auth', 'otp.verified', 'impersonate', 'acivatedProject'])->group(function () {
    Route::get('user/billing', [SubscriptionController::class, 'mySubscription'])->name('subscription.billing');
    Route::get('available-plans', [SubscriptionController::class, 'availablePlans'])->name('available.plans');
    Route::post('subscription/validate-trial', [SubscriptionController::class, 'validateTrialPlanRequest'])->name('subscription.validate.trial');
    Route::get('subscription/trial-forward/{id}', [SubscriptionController::class, 'trialStripeRedirect'])->name('subscription.trial.forward');
    Route::get('pending-subscription', [SubscriptionController::class, 'pendingSubscription'])->name('pending.subscription');
    Route::get('upgrade-plan/{id}', [SubscriptionController::class, 'upgradePlan'])->name('upgrade.plan');
    Route::post('upgrade-trial-plan/{id}', [SubscriptionController::class, 'upgradeTrialPlan'])->name('upgrade.trial.plan');
    Route::post('offline-claim', [SubscriptionController::class, 'offlineClaim'])->name('offline.claim');
    Route::post('upgrade-plan/free', [SubscriptionController::class, 'upgradeFreePlan'])->name('upgrade-plan.free');
    Route::post('stripe-redirect', [SubscriptionController::class, 'stripeRedirect'])->name('stripe.redirect');
    Route::get('stripe-success', [SubscriptionController::class, 'stripeSuccess'])->name('stripe.payment.success');
    Route::post('paypal-redirect', [SubscriptionController::class, 'paypalRedirect'])->name('paypal.redirect');
    Route::get('paypal-success', [SubscriptionController::class, 'paypalSuccess'])->name('paypal.payment.success');
    Route::post('paddle-redirect', [SubscriptionController::class, 'paddleRedirect'])->name('paddle.redirect');
    Route::match(['get', 'post'], 'paddle-success', [SubscriptionController::class, 'paddleSuccess'])->name('paddle.payment.success');
    Route::post('razor_pay-redirect', [SubscriptionController::class, 'razorPayRedirect'])->name('razor.pay.redirect');
    Route::match(['post', 'get'], 'client/razor_pay-success', [SubscriptionController::class, 'razorPaySuccess'])->name('razor.pay.payment.success');
    Route::post('mercadopago-redirect', [SubscriptionController::class, 'mercadopagoRedirect'])->name('mercadopago.redirect');
    Route::match(['post', 'get'], 'mercadopago-success', [SubscriptionController::class, 'mercadopagoSuccess']);
    Route::delete('stop-recurring/{id}', [SubscriptionController::class, 'stopRecurring'])->name('stop.recurring');
    Route::delete('enable-recurring/{id}', [SubscriptionController::class, 'enableRecurring'])->name('enable.recurring');
    Route::delete('cancel-subscription/{id}', [SubscriptionController::class, 'cancelSubscription'])->name('cancel.subscription');
    Route::get('partner/dashboard', [PartnerController::class, 'partnerDashboard'])->name('partner.dashboard');
    Route::get('partner/add-company', [PartnerController::class, 'addCompany'])->name('partner.add.company');
    Route::post('partner/savecompany', [PartnerController::class, 'storeCompany'])->name('partner.companies.store');
    Route::post('/razorpaysubscribe/webhook', [SubscriptionController::class, 'razorWebhook'])->name('razorpaysubscribe.webhook');
});

Route::middleware('web', SubscriptionMiddleware::class)->group(function () {
    Route::get('subscription-info', [SubscriptionController::class, 'mySubscription'])->name('subscription.info');
});

Route::get('account/profile/show', [UserProfileController::class, 'show'])->name('account.profile.show');
Route::get('account/profile/api', [UserProfileController::class, 'api'])->name('account.profile.api');
Route::get('account/profile/billing', [UserProfileController::class, 'billing'])->name('account.profile.billing');
Route::put('account/profile/{id}/update', [UserProfileController::class, 'update'])->name('account.profile.update');
Route::put('profile/update/billing', [UserProfileController::class, 'updateBilling'])->name('account.profile.billing.update');

Route::post('/save_data_google_facebook', [UserProfileController::class, 'saveData'])->name('save_data_google_facebook');
Route::post('/store/billing_data', [UserProfileController::class, 'storeBilling'])->name('store.billing');
Route::post('/omit_modal', [UserProfileController::class, 'omitModal'])->name('omit_modal');

// HubSpot
Route::post('/hubspot/contact/add', [HubSpotController::class, 'addContact'])->name('addContact');
Route::put('/hubspot/contact/update/{contactId}', [HubSpotController::class, 'updateContact']);
Route::post('/hubspot/list/{listId}/add/{contactId}', [HubSpotController::class, 'addContactToList']);
Route::delete('/hubspot/list/{listId}/remove/{contactId}', [HubSpotController::class, 'removeContactFromList']);

//Register Phone
Route::post('/phone-register', [registerController::class, 'store'])->name('phoneRegister');

//AUTH
Route::middleware('web')->group(function () {
    Route::get('/login/google', [SocialController::class, 'googleRedirectToProvider'])->name('google.login');
    Route::get('/login/google/redirect', [SocialController::class, 'googleHandleProviderCallback']);
    Route::get('/login/facebook', [App\Http\Controllers\Auth\SocialController::class, 'facebookRedirectToProvider'])->name('facebook.login');
    Route::get('/login/facebook/redirect', [SocialController::class, 'facebookHandleProviderCallback']);

    //password/reset to /forgot-password
    Route::get('password/reset', function () {
        return redirect('forgot-password');
    });
});

//Frontend Controller
Route::get('/', [FrontEndController::class, 'index'])->name('landing');
//*** CUSTOM ROUTES */
Route::get('/pricing', [FrontEndController::class, 'pricing'])->name('front.pricing');
// Route::get('/features', [FrontEndController::class, 'features'])->name('front.features');
Route::get('/products', [FrontEndController::class, 'products'])->name('front.products'); //changes made by amit
Route::get('/help', [FrontEndController::class, 'help'])->name('front.help');
Route::get('/contact', [FrontEndController::class, 'contact'])->name('front.contact');
Route::get('/partner-program', [FrontEndController::class, 'partner_program'])->name('front.partner_program');
Route::get('/agreement', [FrontEndController::class, 'agreement'])->name('front.agreement');
Route::get('/getFacebookLeadInfo', [FrontEndController::class, 'getFacebookLeadInfo'])->name('front.getFacebookLeadInfo');

Route::get('/whatsapp-business-api', [FrontEndController::class, 'whatsapp_business_api'])->name('front.whatsapp-business-api');
Route::get('/whatsapp-automation', [FrontEndController::class, 'whatsapp_automation'])->name('front.whatsapp-automation');
Route::get('/whatsapp-broadcast', [FrontEndController::class, 'whatsapp_broadcast'])->name('front.whatsapp-broadcast');
Route::get('/whatsapp-chat-button', [FrontEndController::class, 'whatsapp_chat_button'])->name('front.whatsapp-chat-button');
Route::get('/whatsapp-chatbot', [FrontEndController::class, 'whatsapp_chatbot'])->name('front.whatsapp-chatbot');
Route::get('/whatsapp-conversation-pricing-calculator', [FrontEndController::class, 'whatsapp_conversation_pricing_calculator'])->name('front.whatsapp-conversation-pricing-calculator');
Route::get('/whatsapp-marketing', [FrontEndController::class, 'whatsapp_marketing'])->name('front.whatsapp-marketing');

Route::get('/whatsapp_add', [FrontEndController::class, 'whatsapp_add'])->name('front.whatsapp_add');
Route::get('/whatsapp_qr', [FrontEndController::class, 'whatsapp_qr'])->name('front.whatsapp_qr');
Route::get('/whatsapp-link-generator', [FrontEndController::class, 'whatsapp_link_generator'])->name('front.whatsapp_link_generator');
Route::get('/whatsapp-flows', [FrontEndController::class, 'whatsapp_flows'])->name('front.whatsapp-flows');
Route::get('/whatsapp-drip-marketing', [FrontEndController::class, 'whatsapp_drip_marketing'])->name('front.whatsapp-drip-marketing');
Route::get('/ai-whatsapp-template-generator', [FrontEndController::class, 'ai_whatsapp_template_generator'])->name('front.ai-whatsapp-template-generator');
Route::get('/whatsapp-shared-inbox', [FrontEndController::class, 'whatsapp_shared_inbox'])->name('front.whatsapp-shared-inbox');
Route::get('/whatsapp-payments', [FrontEndController::class, 'whatsapp_payments'])->name('front.whatsapp-payments');
Route::get('/gdpr-policy', [FrontEndController::class, 'gdpr_policy'])->name('gdpr-policy');
Route::get('/onboarding', [FrontEndController::class, 'onboarding'])->name('onboarding');

Route::middleware(['auth'])->group(function () {
    Route::get('/verify-otp', [OtpController::class, 'show'])->name('verify-otp');
    Route::post('/verify-otp', [OtpController::class, 'verify'])->name('otp.verify');
    Route::post('/resend-otp', [OtpController::class, 'resendOtp'])->name('resend.otp');
    Route::post('/update-phone', [OtpController::class, 'updatePhone'])->name('update-phone');
});

//Partners
Route::middleware(['web', 'auth', 'impersonate', 'acivatedProject'])->group(function () {
    Route::get('/partners', [PartnerController::class, 'index'])->name('partners.index');
    Route::get('/partners/create', [PartnerController::class, 'create'])->name('partners.create');
    Route::post('/partners', [PartnerController::class, 'store'])->name('partners.store');
    Route::get('/partners/{partner}/edit', [PartnerController::class, 'edit'])->name('partners.edit');
    Route::put('/partners/{partner}', [PartnerController::class, 'update'])->name('partners.update');
    Route::post('/partners/{partner}/toggle-status', [PartnerController::class, 'toggleStatus'])->name('partners.toggle-status');
    Route::get('/partners/{user}/info', [PartnerController::class, 'fetchUserInfo'])->name('partners.fetchUserInfo');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/password/update', [UserProfileController::class, 'updatePassword'])
        ->name('frontend.password.update');
});

Route::middleware(['web', 'auth', 'otp.verified', 'impersonate', 'acivatedProject'])->group(function () {
    Route::get('/dashboard/{lang?}', [App\Http\Controllers\DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/home/{lang?}', [App\Http\Controllers\DashboardController::class, 'dashboard'])->name('home');

    Route::name('admin.')->group(function () {
        Route::resource(config('settings.url_route_plural', 'companies'), 'App\Http\Controllers\CompaniesController', [
            'names' => [
                'index' => 'companies.index',
                'store' => 'companies.store',
                'edit' => 'companies.edit',
                'create' => 'companies.create',
                'destroy' => 'companies.destroy',
                'update' => 'companies.update',
                'show' => 'companies.show',
            ],
        ]);

        Route::get('/coupons', [CouponController::class, 'index'])->name('coupons.index');
        Route::get('/coupons/{id}/edit', [CouponController::class, 'edit'])->name('coupons.edit');
        Route::post('/coupons/{id}/edit', [CouponController::class, 'update'])->name('coupons.update');
        Route::delete('/coupons/{id}', [CouponController::class, 'destroy'])->name('coupons.destroy');
        Route::post('/apply-coupon', [CouponController::class, 'applyCouponToSubscription'])->name('apply.coupon');
        Route::post('/create-coupon', [CouponController::class, 'createCoupon'])->name('create.coupon');
        Route::get('/coupons/create', [CouponController::class, 'showCreateCouponForm'])->name('add.coupons');
        Route::post('/validate-coupon', [CouponController::class, 'validateCoupon']);

        //Other companies routes
        Route::get('removecompany/{company}', [App\Http\Controllers\CompaniesController::class, 'remove'])->name('company.remove');
        Route::get('/company/{company}/activate', [App\Http\Controllers\CompaniesController::class, 'activateCompany'])->name('company.activate');
        Route::put('companies_app_update/{company}', [App\Http\Controllers\CompaniesController::class, 'updateApps'])->name('company.updateApps');
        Route::get('companies/loginas/{company}', [App\Http\Controllers\CompaniesController::class, 'loginas'])->name('companies.loginas');
        Route::get('companies/remove-no-use-data/{company_id}', [CompaniesController::class, 'removeNoUseData'])->name('companies.remove.no.use.data');

        //Switch company
        Route::get('companies/switch/{company}', [App\Http\Controllers\CompaniesController::class, 'switch'])->name('companies.switch');

        //Organization management
        Route::get('organizations/manage', [App\Http\Controllers\CompaniesController::class, 'manage'])->name('organizations.manage');
        Route::post('organizations/create', [App\Http\Controllers\CompaniesController::class, 'createOrganization'])->name('organizations.create');
        Route::get('organizations/edit/{company}', [App\Http\Controllers\CompaniesController::class, 'editOrganization'])->name('organizations.edit');
        Route::put('organizations/update/{company}', [App\Http\Controllers\CompaniesController::class, 'updateOrganization'])->name('organizations.update');

        Route::get('stopimpersonate', [App\Http\Controllers\CompaniesController::class, 'stopImpersonate'])->name('companies.stopImpersonate');
        Route::get('/share', [App\Http\Controllers\CompaniesController::class, 'share'])->name('share');

        Route::resource('settings', 'App\Http\Controllers\SettingsController');

        // Landing page settings
        Route::get('landing', [App\Http\Controllers\SettingsController::class, 'landing'])->name('landing');
        Route::controller(PostsController::class)
            ->prefix('landing')
            ->name('landing.')
            ->group(function () {
                Route::get('posts/{type}', 'index')->name('posts');
                Route::get('posts/{type}/create', 'create')->name('posts.create');
                Route::post('posts/{type}', 'store')->name('posts.store');

                Route::get('posts/edit/{post}', 'edit')->name('posts.edit');
                Route::put('posts/{post}', 'update')->name('posts.update');
                Route::get('posts/del/{post}', 'destroy')->name('posts.delete');
            });

        //Apps
        Route::get('apps', [AppsController::class, 'index'])->name('apps.index');
        Route::get('company_apps', [AppsController::class, 'companyApps'])->name('apps.company');
        Route::get('appremove/{alias}', [AppsController::class, 'remove'])->name('apps.remove');
        Route::post('apps', [AppsController::class, 'store'])->name('apps.store');
        // Route::put('company_apps_update', [AppsController::class, 'updateApps'])->name('owner.updateApps');
        // Route::put('company_apps_update', [App\Http\Controllers\AppsController::class, 'updateApps'])->name('owner.updateApps');
        Route::get('apps/update_plugin_via_file', [AppsController::class, 'store'])->name('apps.update_plugin_via_file');

        Route::match(['put', 'post'], '/admin/owner/update-apps/{company}', [App\Http\Controllers\AppsController::class, 'updateApps'])
    ->name('owner.updateApps');

        Route::get('company_apps/{id}', [AppsController::class, 'show'])->name('apps.company.show');
    });

    Route::resource('plans', PlansController::class);
    Route::controller(PlansController::class)->group(function () {
        Route::post('/subscribe/plan', 'subscribe')->name('plans.subscribe');
        Route::get('/subscribe/cancel', 'cancelStripeSubscription')->name('plans.cancel');
        Route::get('/subscribe/plan3d/{plan}/{user}', 'subscribe3dStripe')->name('plans.subscribe_3d_stripe');
        Route::post('/subscribe/update', 'adminupdate')->name('update.plan');
    });

    Route::resource('credits', CreditsController::class);
    Route::post('/credits/costs', [CreditsController::class, 'updateCosts'])->name('credits.costs');
    Route::get('/billing', function (Request $request) {
        return $request->user()->redirectToBillingPortal(route('plans.current'));
    })->name('billing');
});

//Verify
Route::middleware('web')->group(function () {
    Route::get('/activation/{code}', [SettingsController::class, 'activation'])->name('project.activation');
});

//Verify
Route::middleware('web')->group(function () {
    Route::get('/activation/{code}', [SettingsController::class, 'activation'])->name('project.activation');
});

// terms-conditions
Route::get('/terms-conditions', function () {
    return view('frontend.term_conditions');
})->name('terms-conditions');

// privacy_policy
Route::get('/privacy-policy', function () {
    return view('frontend.privacy_policy');
})->name('privacy-policy');

Route::get('/refund-policy', function () {
    return view('frontend.refund_policy');
})->name('refund-policy');

Route::get('/cancellation-policy', function () {
    return view('frontend.cancellation_policy');
})->name('cancellation-policy');

Route::post('/contact/submit', [FrontEndController::class, 'contactFormSubmit'])->name('contact.submit');
Route::get('cron-sync-leads', [App\Http\Controllers\FBLeadController::class, 'fetchAllCampaignLeads'])->name('cron-fb-leads');
