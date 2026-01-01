<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Plans;
use App\Models\Subscription_Info;
use Modules\Contacts\Models\Contact;
use App\Models\StripeSession;
use App\Models\SubscriptionTransactionLog;
use App\Models\User;
use App\Repositories\Client\SubscriptionRepository;
use App\Repositories\PlanRepository;
use App\Traits\PaymentTrait;
use App\Traits\RepoResponse;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Stripe\Stripe;
use Stripe\Coupon as StripeCoupon;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Stripe\Customer;
use Stripe\Invoice;
use Stripe\PaymentIntent;
use Stripe\Subscription;
 use Illuminate\Support\Facades\Http;

class SubscriptionController extends Controller
{
    use PaymentTrait, RepoResponse;

    protected $planRepository;

    protected $subscriptionRepository;

    public function __construct(PlanRepository $planRepository, SubscriptionRepository $subscriptionRepository)
    {
        $this->planRepository         = $planRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        Stripe::setApiKey(config('settings.stripe_secret'));
    }

    public function mySubscription()
    {
        $company            = auth()->user()->resolveCurrentCompany();
        $Subscription       = $company->activeSubscription;
        if($Subscription == null){
            $Subscription = auth()->user()->userActiveSubscription;
        }
        $active_subscription = $Subscription;
        $billingHistory = [];
        if ($company->stripe_customer_id) {
            $billingHistory = $this->getCustomerPaymentsAndInvoice($company->stripe_customer_id);
            //    dd($billingHistory);
        }
        $log_details        = SubscriptionTransactionLog::where('company_id', auth()->user()->company_id)->latest()->paginate(10);
        $total_team         = User::where('company_id', auth()->user()->company_id)->where('status', 1)->count();
        $total_contacts     = Contact::where('company_id', auth()->user()->company_id)->where('status', 1)->count();
        $teams_remaining    = $Subscription->team_limit ?? 0    - $total_team;
        $contacts_remaining = $Subscription->contact_limit ?? 0 - $total_contacts;
        $company             = auth()->user()->resolveCurrentCompany();
        $data               = [
            'company'             => $company,
            'team_remaining'      => $teams_remaining,
            'contact_remaining'   => $contacts_remaining,
            'active_subscription' => $active_subscription,
            'log_detail'          => $log_details,
            'billingHistory'      => $billingHistory,
        ];
        
        return view('client.subscription.subscription_info', $data);
    }

    public function oldCompanyPlanMigrationsAction($company)
    {
        //for old company to migrate to new subscription plans
        $free_plan = config('settings.free_pricing_id') ?? null;
        $old_plan = auth()->user()->plan_id;
        if ($old_plan != $free_plan) {
            $status = 1;
            $plan = Plans::where('id', $old_plan)->first();
            $trx_id  = Str::random();
            $is_recurring = 0;
            $expire_date  = now(); 
            $billing_period = 'Monthly';

            if ($plan->period == 1) {
                $expire_date  = now()->addMonths();
                $is_recurring = 1;
                $billing_period = 'Monthly';
            } elseif ($plan->period == 2) {
                $expire_date  = now()->addYears();
                $is_recurring = 1;
                $billing_period = 'Yearly';
            } elseif ($plan->period == 3) {
                $expire_date  = now()->addYears(100);
                $is_recurring = 0;
                $billing_period = 'Lifetime';
            }
            $amount_paid = 0;
            $stripe_invoice_details = null;
            $payment_details = '';
            $payment_method = 'set_by_admin';
            $auth_user = auth()->user()->id;
            if ($auth_user) {
                $subscriptions_info = DB::table('subscriptions')
                    ->where('user_id', $auth_user)
                    ->where('stripe_status', 'active')
                    ->first();
                //   dd($subscriptions_info);
                if ($subscriptions_info) {
                    $payment_response =  $this->getSubscriptionDetails($subscriptions_info->stripe_id);
                    // dd($payment_response);
                    if ($payment_response) {
                        $payment_method = 'stripe';
                        $invoice_id = $this->getCurrentInvoiceId($subscriptions_info->stripe_id);
                        $subscriptionDetails = null;
                        if ($invoice_id) {
                            $subscriptionDetails = [
                                'subscription' => $subscriptions_info->stripe_id,
                                'invoice' => $invoice_id,
                                'cancel_at_period_end' => $expire_date
                            ];
                        }
                        $payment_details = $subscriptionDetails;
                        $payment_info = $this->getPaymentDetailsByInvoiceId($invoice_id);
                        $stripe_invoice_details = json_encode($payment_info);
                        if ($payment_info && isset($payment_info['amount_without_currency'])) {
                            $amount_paid = $payment_info['amount_without_currency'];
                        }
                    }
                    //  dd($payment_details );
                }
            }
            $data         = [
                'company_id'             => $company->id,
                'plan_id'                => $plan->id,
                'is_recurring'           => $is_recurring,
                'status'                 => $status,
                'purchase_date'          => now(),
                'expire_date'            => $expire_date,
                'plan_name'              => $plan->name,
                'price'                  => $plan->price,
                'is_trial'               => 0,
                'amount_paid'            => $amount_paid,
                'stripe_invoice_details' => $stripe_invoice_details,
                'package_type'           => $plan->period,
                'contact_limit'          => $plan->contact_limit,
                'campaign_limit'         => $plan->campaigns_limit,
                'campaign_remaining'     => $plan->campaigns_limit,
                'conversation_limit'     => $plan->conversation_limit,
                'conversation_remaining' => $plan->conversation_limit,
                'team_limit'             => $plan->team_limit,
                'max_chatwidget'         => $plan->max_chatwidget ?? 0,
                'max_flow_builder'       => $plan->max_flow_builder ?? 0,
                'max_bot_reply'          => $plan->max_bot_reply ?? 0,
                'trx_id'                 => $trx_id,
                'payment_method'         => $payment_method,
                'payment_details'        => $payment_details,
                'company'                => $company,
                'billing_name'           => $company->billing_name,
                'billing_email'          => $company->billing_email,
                'billing_address'        => $company->billing_address,
                'billing_city'           => $company->billing_city,
                'billing_state'          => $company->billing_state,
                'billing_zip_code'       => $company->billing_zipcode,
                'billing_country'        => $company->billing_country,
                'billing_phone'          => $company->billing_phone,
                'subject'                => __('package_subscription_confirmation') . ' ' . env('APP_NAME'),
            ];

            $log = SubscriptionTransactionLog::create([
                'description' => __('plan_assigned_to_user_by_admin') . ' ' . $plan->name . ' ' . __('plan'),
                'company_id' => $company->id,
            ]);


            // Update HubSpot List for paid customers
            $this->subscriptionRepository->updateHubSpotList($plan->id);

            return Subscription_Info::create($data);
        }
    }

    public function getCurrentInvoiceId($subscriptionId)
    {
        try {
            $invoices = Invoice::all(['subscription' => $subscriptionId, 'limit' => 1]);
            if ($invoices->data && count($invoices->data) > 0) {
                $invoiceId = $invoices->data[0]->id;
                return $invoiceId;
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getSubscriptionDetails($subscriptionId)
    {
        try {
            $subscription = Subscription::retrieve($subscriptionId);
            $invoice = Invoice::retrieve($subscription->latest_invoice);
            $paymentIntent = $invoice->payment_intent ? \Stripe\PaymentIntent::retrieve($invoice->payment_intent) : null;
            return response()->json([
                'subscription' => $subscription,
                'invoice' => $invoice,
                'payment_intent' => $paymentIntent
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getPaymentDetailsByInvoiceId($invoiceId)
    {
        try {
            $invoice = Invoice::retrieve($invoiceId);

            $amountWithSymbol = $this->formatCurrency($invoice->amount_paid / 100, $invoice->currency);

            $lineItems = $invoice->lines->data;
            $products = [];
            foreach ($lineItems as $item) {
                $products[] = [
                    'product_name' => $item->description,
                    'quantity' => $item->quantity,
                    'unit_price' => $this->formatCurrency($item->amount / 100, $invoice->currency), // Unit price with currency symbol
                ];
            }

            $paymentDetails = [
                'invoice_id' => $invoice->id,
                'customer' => $invoice->customer,
                'date' => date('Y-m-d', $invoice->created),
                'amount' => $amountWithSymbol,
                'amount_without_currency' => $invoice->amount_paid / 100,
                'status' => $invoice->status,
                'description' => $invoice->description,
                'invoice_pdf' => $invoice->invoice_pdf,
                'products' => $products,
            ];

            return $paymentDetails;
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function pendingSubscription()
    {

        return view('backend.client.subscription.pending_subscription');
    }

    public function billingManager()
    {
        //The curent plan -- access for owner only
        if (! auth()->user()->hasRole('owner')) {
            abort(403, 'Unauthorized action.');
        }

        $theSelectedProcessor = strtolower(config('settings.subscription_processor', 'stripe'));

        try {
            $company = auth()->user()->resolveCurrentCompany();
            if (
                ! ($theSelectedProcessor == 'stripe' || $theSelectedProcessor == 'local') &&
                auth()->user()->plan_status != 'set_by_admin' &&
                ! config('settings.is_demo') &&
                config('app.url') != 'http://localhost'
            ) {
                $className = '\Modules\\' . ucfirst($theSelectedProcessor) . 'Subscribe\Http\Controllers\App';
                $ref = new \ReflectionClass($className);
                $ref->newInstanceArgs()->validate(auth()->user());
            }

            $plans = config('settings.forceUserToPay', false) ? Plans::where('id', '!=', intval(config('settings.free_pricing_id')))->get()->toArray() : Plans::get()->toArray();

            $colCounter = [4, 12, 6, 4, 3, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4];

            $currentUserPlan = Plans::withTrashed()->find(auth()->user()->mplanid());
            $planAttribute = auth()->user()->company->getPlanAttribute();

            $data = [
                'col' => $colCounter[count($plans)],
                'plans' => $plans,
                'currentPlan' => $currentUserPlan,
                'planAttribute' => $planAttribute,
                'packages'            => $this->planRepository->activePlans(),
                'client'              => $company->id,
                'active_subscription' => auth()->user()->plan_id
            ];

            if (
                $theSelectedProcessor == 'stripe'
                && config('app.url') != 'http://localhost'
                && ! config('settings.is_demo')
            ) {
                $data['intent'] = auth()->user()->createSetupIntent();
            }

            $data['trial_used'] = $company->trial_used;
            $data['subscription_processor'] = $theSelectedProcessor;

            //reset trial plan request session first load
            Session::forget('trial_plan_request');

            return view('client.subscription.upgrade_plan', $data);
        } catch (Exception $e) {
            //  logError('availablePlans: ', $e);

            return back()->with('error', 'something_went_wrong_please_try_again');
        }
    }

    public function availablePlans()
    {
        //The curent plan -- access for owner only
        if (! auth()->user()->hasRole('owner')) {
            abort(403, 'Unauthorized action.');
        }

        //reset trial session first load
        Session::forget('trial_plan_request');
        Session::forget('trial_session_id');
        Session::forget('coupon_validation');
        Session::forget('coupon');
        Session::forget('coupon_id');
        Session::forget('used_coupon_id');
        Session::forget('trial_days');

        //  dd(session_name('trial_plan_request')

        $theSelectedProcessor = strtolower(config('settings.subscription_processor', 'razorpay'));
        
        try {
            $company = auth()->user()->resolveCurrentCompany();
            $current_old_plan = auth()->user()->plan_id;
            $Subscription       = Subscription_Info::where('company_id', $company->id)
            ->where('status', '1')
            ->latest()
            ->first();
            
            //  dd($Subscription);
            if (!$Subscription && $current_old_plan) {
                //dd($company);
                // plan migration for old company
                $this->oldCompanyPlanMigrationsAction($company);
            }
            if (
                ! ($theSelectedProcessor == 'stripe' || $theSelectedProcessor == 'local') &&
                auth()->user()->plan_status != 'set_by_admin' &&
                ! config('settings.is_demo') &&
                config('app.url') != 'http://localhost'
            ) {
                $className = '\Modules\\' . ucfirst($theSelectedProcessor) . 'Subscribe\Http\Controllers\App';
                $ref = new \ReflectionClass($className);
                $ref->newInstanceArgs()->validate(auth()->user());
            }

            $plans = config('settings.forceUserToPay', false) ? Plans::where('id', '!=', intval(config('settings.free_pricing_id')))->get()->toArray() : Plans::get()->toArray();
            
            $colCounter = [4, 12, 6, 4, 3, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4];

            $currentUserPlan = Plans::withTrashed()->find(auth()->user()->mplanid());
            
            $planAttribute = auth()->user()->company->getPlanAttribute();

            $data = [
                'col' => $colCounter[count($plans)],
                'plans' => $plans,
                'currentPlan' => $currentUserPlan,
                'planAttribute' => $planAttribute,
                'packages'            => $this->planRepository->activePlans(),
                'client'              => $company->id,
                'active_subscription' => auth()->user()->plan_id
            ];

            if (
                $theSelectedProcessor == 'stripe'
                && config('app.url') != 'http://localhost'
                && ! config('settings.is_demo')
            ) {
                $data['intent'] = auth()->user()->createSetupIntent();
            }

            $data['trial_used'] = $company->trial_used;
            $data['subscription_processor'] = $theSelectedProcessor;
            
            //reset trial plan request session first load
            Session::forget('trial_plan_request');

            return view('client.subscription.upgrade_plan', $data);
        } catch (Exception $e) {
            logError('availablePlans: ', $e);
            return back()->with('error', 'something_went_wrong_please_try_again'.$e->getMessage());
        }
    }

    public function upgradePlan($id): Factory|View|Application|RedirectResponse
    {
        try {

            $trial_plan_request  = null;
            $trial_session_id  = null;
            if (!session()->has('trial_plan_request') || session('trial_plan_request') != 1) {
                $trial_session_id = session('trial_session_id');
                $trial_plan_request = session('trial_plan_request');
            }

            $plan = $this->planRepository->find($id);

            // dd($plan);
            $data = [
                'package' => $plan,
                'coupon_used' => auth()->user()->company->coupon_used,
                'trx_id'  => Str::random(),
                'company' => auth()->user()->company,
                'trial_plan_request' => $trial_plan_request,
                'trial_session_id' => $trial_session_id,
            ];
            // dd(session('trial_plan_request'));
            Session::forget('coupon_validation');
            Session::forget('coupon');
            Session::forget('coupon_id');
            Session::forget('used_coupon_id');
            Session::forget('trial_days');

            return view('client.subscription.payment_page', $data);
        } catch (Exception $e) {
            //  logError('upgradePlan: ', $e);
            return back()->with('error', 'something_went_wrong_please_try_again');
        }
    }

    public function upgradeTrialPlan($id): Factory|View|Application|RedirectResponse
    {
        try {

            $plan = $this->planRepository->find($id);
            $data = [
                'package' => $plan,
                'coupon_used' => auth()->user()->company->coupon_used,
                'trx_id'  => Str::random(),
                'company' => auth()->user()->company,
            ];
            if (!session()->has('trial_plan_request') || session('trial_plan_request') != 1) {

                return redirect()->route('available.plans');
            }

            // Session::forget('trial_plan_request');
            //  Session::forget('trial_session_id');
            Session::forget('coupon_validation');
            Session::forget('coupon');
            Session::forget('coupon_id');
            Session::forget('used_coupon_id');
            Session::forget('trial_days');

            return view('client.subscription.payment_page', $data);
        } catch (Exception $e) {
            //  logError('upgradePlan: ', $e);
            return back()->with('error', 'something_went_wrong_please_try_again');
        }
    }

    public function validateTrialPlanRequest(Request $request)
    {

        $planId = $request->input('plan_id');
        //   dd($request->all());
        // Perform your validation logic for free trial (e.g., check eligibility, availability)
        $isEligibleForTrial = $this->checkTrialEligibility($planId);

        if ($isEligibleForTrial) {
            // Store session ID for the trial
            Session::put('trial_session_id', uniqid('trial_', true));
            Session::put('trial_plan_request', 1);

           // $this->trialStripeRedirect($planId);
         //  return redirect()->route('subscription.trial.forward');
            return response()->json([
                'success' => true,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'You are not eligible for a free trial.'
        ]);
    }

    private function checkTrialEligibility($planId)
    {
        $plan  = $this->planRepository->find($planId);
        if ($plan->status == 1) {
            return true;
        }
        return false;
    }

    public function current(): View
    {
        //The curent plan -- access for owner only
        if (! auth()->user()->hasRole('owner')) {
            abort(403, 'Unauthorized action.');
        }

        $theSelectedProcessor = strtolower(config('settings.subscription_processor', 'stripe'));

        if (
            ! ($theSelectedProcessor == 'stripe' || $theSelectedProcessor == 'local') &&
            auth()->user()->plan_status != 'set_by_admin' &&
            ! config('settings.is_demo') &&
            config('app.url') != 'http://localhost'
        ) {
            $className = '\Modules\\' . ucfirst($theSelectedProcessor) . 'Subscribe\Http\Controllers\App';
            $ref = new \ReflectionClass($className);
            $ref->newInstanceArgs()->validate(auth()->user());
        }

        $plans = config('settings.forceUserToPay', false) ? Plans::where('id', '!=', intval(config('settings.free_pricing_id')))->get()->toArray() : Plans::get()->toArray();

        $colCounter = [4, 12, 6, 4, 3, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4];

        $currentUserPlan = Plans::withTrashed()->find(auth()->user()->mplanid());
        $planAttribute = auth()->user()->company->getPlanAttribute();

        $data = [
            'col' => $colCounter[count($plans)],
            'plans' => $plans,
            'currentPlan' => $currentUserPlan,
            'trial_used' => auth()->user()->company->trial_used,
            'planAttribute' => $planAttribute,
        ];

        if (
            $theSelectedProcessor == 'stripe'
            && config('app.url') != 'http://localhost'
            && ! config('settings.is_demo')
        ) {
            $data['intent'] = auth()->user()->createSetupIntent();
        }

        $data['subscription_processor'] = $theSelectedProcessor;

        //reset trial plan request session first load
        Session::forget('trial_plan_request');
        return view('client.subscription.upgrade_plan', $data);
    }

    public function offlineClaim(Request $request)
    {
        try {
            $trx_id = 'offline-' . uniqid();
            $plan   = $this->planRepository->find($request->plan_id);
            $this->subscriptionRepository->create($plan, $trx_id, '', $request, true);

            return $this->formatResponse(true, __('purchased_successfully'), route('client.pending.subscription'), []);
        } catch (Exception $e) {

            // logError('offline Claim: ', $e);

            return $this->formatResponse(false, $e->getMessage(), 'client.offline.claim', []);
        }
    }
    public function httpRequest($url, $fields, $headers = [], $is_form = false, $method = 'POST')
    {
        if ($is_form) {
            $response = Http::withHeaders($headers)->timeout(30)->asForm()->$method($url, $fields);
        } else {
            $response = Http::withHeaders($headers)->timeout(30)->$method($url, $fields);
        }

        return $response->json();
    }

    public function createStripeCustomer($company)
    {
        $data     = [
            'name'     => $company->name,
            'email'    => auth()->user()->email,
            'metadata' => $company,
        ];
        $headers  = [
            'Authorization' => 'Basic ' . base64_encode(config('settings.stripe_secret') . ':'),
            'Content-Type'  => 'application/x-www-form-urlencoded',
        ];
        $response = httpRequest('https://api.stripe.com/v1/customers', $data, $headers, true);
        auth()->user()->stripe_id = $response['id'];
        auth()->user()->update();
        return $company->update(['stripe_customer_id' => $response['id']]);
    }

    public function upgradeFreePlan(Request $request)
    {
        $package = $this->planRepository->findActive($request->package_id);
        if ($package->is_free == 1 && $package->price == 0) {
            $trx_id = 'free-' . uniqid();
            $this->subscriptionRepository->create($package, $trx_id, '', $request, false, 'free');

            return redirect()->route('client.dashboard');
        }

        return back();
    }

    private function billingData($request): array
    {
        $billingInfo = [
            'billing_name'          => $request->billing_name,
            'billing_email'         => $request->billing_email,
            'billing_address'       => $request->billing_address,
            'billing_city'          => $request->billing_city,
            'billing_state'         => $request->billing_state,
            'billing_zipcode'       => $request->billing_zipcode,
            'billing_country'       => $request->billing_country,
            'country_selector_code' => $request->country_selector_code,
            'billing_phone'         => $request->billing_phone,
            'full_number'           => $request->full_number,
            'plan_id'               => $request->plan_id,
            'trx_id'                => $request->trx_id,
        ];
        Session::put('billing_info', $billingInfo);

        return $billingInfo;
    }

    public function trialStripeRedirect($id)
    {
        //$plan_id = $request->input('plan_id');+
        $response  = response()->json(['id' => $id]);
        $data = $response->getData(true);
        $plan_id = $data['id'];

        if(session('trial_plan_request') != 1){
            return redirect()->route('available.plans')->with('error', __('invalid_request'));
        }

        if ($plan_id) {
            Session::forget('used_coupon_id');
            Session::forget('coupon_validation');
            Session::forget('coupon');
            Session::forget('coupon_id');
            Session::forget('trial_days');
            try {
                $plan_info        = $this->planRepository->find($plan_id);
                $trx_id  = Str::random();
                if ($plan_info) {

                //dd($plan_info);
                    $company         = auth()->user()->resolveCurrentCompany();
                    if (! $company->stripe_customer_id) {
                        $this->createStripeCustomer($company);
                    }
                    $stripe_plan_id        = $plan_info->stripe_id;
                    if (! $stripe_plan_id) {
                        return redirect()->route('available.plans')->with('error', __('stripe_plan_not_found'));
                    }

                    $stripe_session = StripeSession::create([
                        'plan_id'   => $plan_id,
                        'company_id' => $company->id,
                    ]);
                    $this->billingData($company);

                    $session        = [
                        'customer'             => $company->stripe_customer_id,
                        'payment_method_types' => ['card'],
                        'line_items'           => [
                            [
                                'price'    => $stripe_plan_id,
                                'quantity' => 1,
                            ],
                        ],
                        'mode'                 => 'subscription',
                        'success_url'          => route('stripe.payment.success', ['session_id' => $stripe_session->id, 'trx_id' => $trx_id]),
                        'cancel_url'           => url()->previous(),
                    ];

                    // Check if trial is already used by company
                    $trial_used = $company->trial_used ?? 0;

                    $trialDays = null;
                    $trialEnd = null;
                    $trialStatus = 0;

                    //check if trial is requested for current plan
                    $isTrialRequested = session('trial_plan_request');
                    //if trail is zero then company abel to use the trial
                    if ($trial_used == 0 && $isTrialRequested) {
                        $trialDays = (int) $plan_info->trial_days + 1;
                        $trialStatus = $plan_info->trial_status;
                        $trialEnd = Carbon::now()->addDays($trialDays)->timestamp; // Calculate the trial end timestamp
                    }

                    // Add trial period if $trialDays > 2 and $trialEnd
                    if ($trialDays > 2 && $trialEnd && $isTrialRequested && $trialStatus == 1) {
                        //pass the trial end date to the subscription information tabel
                        session(['trial_days' => (int) $plan_info->trial_days]);
                        $session['subscription_data'] = [
                            'trial_end' => $trialEnd,
                        ];
                    }

                   // dd($session);
                    $headers        = [
                        'Authorization' => 'Basic ' . base64_encode(config('settings.stripe_secret') . ':'),
                        'Content-Type'  => 'application/x-www-form-urlencoded',
                    ];
                    $response       = httpRequest('https://api.stripe.com/v1/checkout/sessions', $session, $headers, true);
                    if (isset($response['error']) && isset($response['error']['message'])) {

                        return back()->with('error', __($response['error']['message']));
                    }
                    $stripe_session->update(['stripe_session_id' => $response['id']]);

                    session()->forget('trial_plan_request');
                    return redirect($response['url']);
                }
            } catch (Exception $e) {
                //  logError('stripeRedirect : ', $e);
                if ($e instanceof ApiErrorException && $e->getError()->code === 'resource_missing') {
                    //Toastr::error('Customer not found. Please try again.');

                    return back()->with('error', __('customer_not_found_please_try_again'));
                }

                return back()->with('error', __('an_error_occurred_while_processing_the_request: ' . $e->getMessage()));
            }
        }
    }

    public function stripeRedirect(Request $request): RedirectResponse
    {
        $coupon_id = null;
        $package_id = $request->package_id;
        if ($package_id) {

            if (session('coupon_validation') && session('coupon')) {
                $stripeCouponCode = Coupon::where('name', session('coupon'))->get(['stripe_coupon_id'])->first();
                $coupon_id = $stripeCouponCode->stripe_coupon_id;
            }

            Session::forget('used_coupon_id');
            Session::forget('coupon_validation');
            Session::forget('coupon');
            Session::forget('coupon_id');
            Session::forget('trial_days');

            try {
                $package        = $this->planRepository->find($request->package_id);
                $company         = auth()->user()->resolveCurrentCompany();
                if (! $company->stripe_customer_id) {
                    $this->createStripeCustomer($company);
                }
                $plan_id        = $this->planRepository->getPGCredential($request->package_id, 'stripe_id');
                if (! $plan_id) {
                    // Toastr::error('stripe_plan_not_found');
                    return redirect()->route('available.plans')->with('error', __('stripe_plan_not_found'));
                }

                $stripe_session = StripeSession::create([
                    'plan_id'   => $package->id,
                    'company_id' => $company->id,
                ]);
                $this->billingData($request);

                $session        = [
                    'customer'             => $company->stripe_customer_id,
                    'payment_method_types' => ['card'],
                    'line_items'           => [
                        [
                            'price'    => $plan_id,
                            'quantity' => 1,
                        ],
                    ],
                    'metadata' => [
                        'cardholder_name' => $request->billing_name ?? '', // Full cardholder name
                    ],
                    'mode'                 => 'subscription',
                    'success_url'          => route('stripe.payment.success', ['session_id' => $stripe_session->id, 'trx_id' => $request->trx_id]),
                    'cancel_url'           => url()->previous(),
                ];

                // Check if trial is already used by company
                $trial_used = $company->trial_used ?? 0;

                $trialDays = null;
                $trialEnd = null;
                $trialStatus = 0;

                //check if trial is requested for current plan
                $isTrialRequested = session('trial_plan_request');
                //if trail is zero then company abel to use the trial
                if ($trial_used == 0 && $isTrialRequested) {
                    $trialDays = (int) $package->trial_days + 1;
                    $trialStatus = $package->trial_status;
                    $trialEnd = Carbon::now()->addDays($trialDays)->timestamp; // Calculate the trial end timestamp
                }

                // Add discounts if $coupon_id exists
                if (!empty($coupon_id)) {
                    //pass the used coupon id to add for coupon used increment
                    session(['used_coupon_id' => $coupon_id]);
                    $session['discounts'] = [
                        [
                            'coupon' => $coupon_id,  // Use an array of objects for discounts
                        ],
                    ];
                }
                // Add trial period if $trialDays > 2 and $trialEnd
                if ($trialDays > 2 && $trialEnd && $isTrialRequested && $trialStatus == 1) {
                    //pass the trial end date to the subscription information tabel
                    session(['trial_days' => (int) $package->trial_days]);
                    $session['subscription_data'] = [
                        'trial_end' => $trialEnd,
                    ];
                }
                $headers        = [
                    'Authorization' => 'Basic ' . base64_encode(config('settings.stripe_secret') . ':'),
                    'Content-Type'  => 'application/x-www-form-urlencoded',
                ];
                $response       = httpRequest('https://api.stripe.com/v1/checkout/sessions', $session, $headers, true);
                if (isset($response['error']) && isset($response['error']['message'])) {

                    return back()->with('error', __($response['error']['message']));
                }
                $stripe_session->update(['stripe_session_id' => $response['id']]);

                return redirect($response['url']);
            } catch (Exception $e) {
                //  logError('stripeRedirect : ', $e);
                if ($e instanceof ApiErrorException && $e->getError()->code === 'resource_missing') {
                    //Toastr::error('Customer not found. Please try again.');

                    return back()->with('error', __('customer_not_found_please_try_again'));
                }

                return back()->with('error', __('an_error_occurred_while_processing_the_request: ' . $e->getMessage()));
            }
        }
    }

    public function stripeSuccess(Request $request): Redirector|RedirectResponse|Application
    {
        try {
            $session        = StripeSession::find($request->session_id);
            if (! $session) {
                Toastr::error('invalid_request');
                return redirect()->route('available.plans');
            }
            $headers        = [
                'Authorization' => 'Basic ' . base64_encode(config('settings.stripe_secret') . ':'),
                'Content-Type'  => 'application/x-www-form-urlencoded',
            ];
            $stripe_session = httpRequest('https://api.stripe.com/v1/checkout/sessions/' . $session->stripe_session_id, [], $headers, false, 'GET');
            if (! $stripe_session) {
                Toastr::error('invalid_request');

                return redirect()->route('available.plans');
            }
            if ($stripe_session['payment_status'] != 'paid') {
                Toastr::error('invalid_request');

                return redirect()->route('available.plans');
            }
            $billingInfo    = session('billing_info');
            $package        = $session->plan;

            // Update the coupon used count
            if (session('used_coupon_id')) {
                Coupon::where('stripe_coupon_id', session('used_coupon_id'))->increment('usage_count');
            }

            // Create the payment information
            $this->subscriptionRepository->create($package, $request->trx_id, $stripe_session, $billingInfo);
            Toastr::success('purchased_successfully');

            //update plan id with user information
            auth()->user()->plan_id = $package->id;
            auth()->user()->update();

            return redirect()->route('whatsapp.setup')->with('success', __('purchased_successfully'));
        } catch (\Exception $e) {
            Toastr::error($e->getMessage());
            //logError('stripeSuccess : ', $e);

            return redirect()->route('available.plans')->with('error', $e->getMessage());
        }
    }

    public function paypalTokenGenerator($base_url): string
    {

        //generate access token
        $headers  = [
            'Content-Type'  => 'application/x-www-form-urlencoded',
            'Authorization' => 'Basic ' . base64_encode(setting('paypal_client_id') . ':' . setting('paypal_client_secret')),
        ];
        $data     = [
            'grant_type' => 'client_credentials',
        ];
        $response = httpRequest($base_url . '/v1/oauth2/token', $data, $headers, true);

        return $response['token_type'] . ' ' . $response['access_token'];
    }

    public function paypalRedirect(Request $request): Redirector|RedirectResponse|Application
    {
        if (setting('is_paypal_sandbox_mode_activated')) {
            $base_url = 'https://api-m.sandbox.paypal.com';
        } else {
            $base_url = 'https://api-m.paypal.com';
        }
        $plan_id           = $this->planRepository->getPGCredential($request->package_id, 'paypal');

        if (! $plan_id) {
            // Toastr::error('paypal_plan_not_found');
            return redirect()->route('available.plans')->with('error', __('paypal_plan_not_found'));
        }

        $headers           = [
            'Content-Type'  => 'application/json',
            'Authorization' => $this->paypalTokenGenerator($base_url),
        ];
        $this->billingData($request);

        $subscription_data = [
            'plan_id'             => $plan_id,
            'custom_id'           => $request->package_id,
            'application_context' => [
                'brand_name'          => setting('system_name'),
                'locale'              => 'en-US',
                'shipping_preference' => 'SET_PROVIDED_ADDRESS',
                'user_action'         => 'SUBSCRIBE_NOW',
                'payment_method'      => [
                    'payer_selected'  => 'PAYPAL',
                    'payee_preferred' => 'IMMEDIATE_PAYMENT_REQUIRED',
                ],
                'return_url'          => route('paypal.payment.success', ['trx_id' => $request->trx_id]),
                'cancel_url'          => url()->previous(),
            ],
        ];

        $response          = httpRequest($base_url . '/v1/billing/subscriptions', $subscription_data, $headers);

        return redirect($response['links'][0]['href']);
    }

    public function paypalSuccess(Request $request): RedirectResponse
    {
        try {
            if (setting('is_paypal_sandbox_mode_activated')) {
                $base_url = 'https://api-m.sandbox.paypal.com';
            } else {
                $base_url = 'https://api-m.paypal.com';
            }
            $headers     = [
                'Content-Type'  => 'application/json',
                'Authorization' => $this->paypalTokenGenerator($base_url),
            ];
            $response    = $this->quest($base_url . '/v1/billing/subscriptions/' . $request->subscription_id, [], $headers, false, 'GET');
            $package     = $this->planRepository->find(getArrayValue('custom_id', $response));
            if (! $package) {
                Toastr::error('invalid_request');

                return redirect()->route('available.plans');
            }
            $billingInfo = session('billing_info');
            $this->subscriptionRepository->create($package, $request->trx_id, $response, $billingInfo, false, 'paypal');
            Toastr::success('purchased_successfully');

            return redirect()->route('dashboard')->with('success', __('purchased_successfully'));
        } catch (\Exception $e) {
            Toastr::error('something_went_wrong_please_try_again');
            //  logError('paypalSuccess: ', $e);

            return redirect()->route('available.plans')->with('error', __('something_went_wrong_please_try_again'));
        }
    }

    public function paddleRedirect(Request $request): View|Factory|Application|RedirectResponse
    {
        try {
            $this->billingData($request);
            $data = [
                'plan'     => $this->planRepository->find($request->package_id),
                'price_id' => $this->planRepository->getPGCredential($request->package_id, 'paddle'),
                'trx_id'   => $request->trx_id,
                'client'   => auth()->user()->client,
            ];

            return view('client.subscription.paddle', $data);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                dd($e->getMessage());
            }
            Toastr::error('something_went_wrong_please_try_again');
            // logError('upgradePlan: ', $e);

            return redirect()->route('available.plans')->with('error', __('something_went_wrong_please_try_again'));
        }
    }

    public function paddleSuccess(Request $request): JsonResponse
    {
        try {
            $payment_details                = $request->data;
            $package                        = $this->planRepository->find($request->plan_id);
            if (getArrayValue('status', $payment_details) != 'completed') {
                Toastr::error('invalid_request');

                return response()->json([
                    'error' => 'invalid_request',
                    'route' => route('available.plans'),
                ]);
            }
            $client                         = auth()->user()->client;

            if (getArrayValue('id', $payment_details['customer']) && ! $client->paddle_customer_id) {
                $client->update(['paddle_customer_id' => getArrayValue('id', $payment_details['customer'])]);
            }

            $payment_data['id']             = getArrayValue('id', $payment_details);
            $payment_data['transaction_id'] = getArrayValue('transaction_id', $payment_details);
            $billingInfo                    = session('billing_info');
            $this->subscriptionRepository->create($package, $request->trx_id, $payment_data, $billingInfo, false, 'paddle');
            Toastr::success('purchased_successfully');

            return response()->json([
                'error' => 'invalid_request',
                'route' => route('dashboard'),
            ]);
        } catch (\Exception $e) {
            Toastr::error($e->getMessage());
            // logError('paddleSuccess: ', $e);
            return response()->json([
                'error' => 'invalid_request',
                'route' => route('available.plans'),
            ]);
        }
    }

    

    public function mercadopagoRedirect(Request $request): Redirector|RedirectResponse|Application|null
    {
        try {
            $this->billingData($request);
            $plan               = $this->planRepository->find($request->plan_id);
            $data['amount']     = $plan->price;
            $active_currency    = $this->activeCurrencyCheck();
            $brazilianCurrency  = $this->getCurrency('BRL');
            // Check if Brazilian currency is set
            if (empty($brazilianCurrency)) {
                return redirect()->back()->with('danger', __('please_set_brazilian_currency'));
            }

            $currency_converter = $this->currencyAmountCalculator(null, $data, $active_currency, $brazilianCurrency);
            $payload            = [
                'auto_recurring' => [
                    'frequency'          => 1,
                    'frequency_type'     => 'months',
                    'transaction_amount' => round($currency_converter['total_amount'], 2),
                    'currency_id'        => 'BRL',
                ],
                'back_url'       => url()->previous(),
                'reason'         => 'Yoga classes',
            ];

            $headers            = [
                'Authorization' => 'Bearer ' . setting('mercadopago_access_key'),
                'Content-Type'  => 'application/json',
            ];

            $response           = httpRequest('https://api.mercadopago.com/checkout/preferences', $payload, $headers);

            // Check if response is successful
            if (isset($response['error'])) {
                $errorMessage = $response['error']['message'] ?? $response['message'];

                return redirect()->back()->with('danger', $errorMessage);
            }

            $url                = $response['init_point'] ?? null;

            if (! $url) {
                return redirect()->back()->with('danger', __('invalid_response_from_payment_gateway'));
            }

            return redirect($url);
        } catch (Exception $e) {
            // Toastr::error($e->getMessage());
            //logError('mercadopagoRedirect: ', $e);

            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function mercadopagoSuccess(Request $request): RedirectResponse
    {
        try {
            $subscription_id = $request->subscription_id;
            $headers         = [
                'Authorization' => 'Bearer ' . setting('mercadopago_access_key'),
                'Content-Type'  => 'application/json',
            ];
            $response        = httpRequest("https://api.mercadopago.com/preapproval_plan/$subscription_id", [], $headers, false, 'GET');
            $payment_details = $response;
            $billingInfo     = session('billing_info');
            $package         = $this->planRepository->find($billingInfo['plan_id']);
            if (! in_array($payment_details['status'], ['authorized', 'active'])) {
                // Toastr::error('invalid_request');
                return redirect()->back()->with('danger', __('invalid_request'));
            }
            $this->subscriptionRepository->create($package, $billingInfo['trx_id'], $payment_details, $billingInfo, false, 'razor_pay');
            session()->forget('billing_info');

            // Toastr::success('purchased_successfully');
            return redirect()->route('dashboard')->with('success', __('purchased_successfully'));
        } catch (Exception $e) {
            // Toastr::error($e->getMessage());
            // logError('mercadopagoSuccess : ', $e);

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function stopRecurring($id): JsonResponse
    {
        try {
            $this->subscriptionRepository->stopRecurring($id);

            $data = [
                'status'    => 'success',
                'message'   => __('recurring_stopped_successfully'),
                'title'     => __('success'),
                'is_reload' => true,
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            // logError('stopRecurring: ', $e);
            $data = [
                'status'    => 'danger',
                'message'   => __('something_went_wrong_please_try_again'),
                'title'     => __('error'),
                'is_reload' => false,
            ];

            return response()->json($data);
        }
    }

    public function enableRecurring($id): JsonResponse
    {
        try {
            $this->subscriptionRepository->enableRecurring($id);

            $data = [
                'status'    => 'success',
                'message'   => __('recurring_enable_successfully'),
                'title'     => __('success'),
                'is_reload' => true,
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            // logError('enableRecurring: ', $e);
            $data = [
                'status'    => 'danger',
                'message'   => __('something_went_wrong_please_try_again'),
                'title'     => __('error'),
                'is_reload' => false,
            ];

            return response()->json($data);
        }
    }

    public function cancelSubscription($id): JsonResponse
    {
        try {
            $this->subscriptionRepository->cancelSubscription($id);

            $data = [
                'status'    => 'success',
                'message'   => __('cancelled_successfully'),
                'title'     => __('success'),
                'is_reload' => true,
            ];

            return response()->json($data);
        } catch (\Exception $e) {

            //logError('cancelSubscription error: ', $e);
            $data = [
                'status'    => 'danger',
                'message'   => __('something_went_wrong_please_try_again'),
                'title'     => __('error'),
                'is_reload' => false,
            ];

            return response()->json($data);
        }
    }

    public function getCustomerPaymentsAndInvoice($customerId)
    {

        try {
            $invoices = Invoice::all(['customer' => $customerId]);

            $paymentHistory = [];
            foreach ($invoices->data as $invoice) {
                $amountWithSymbol = $this->formatCurrency($invoice->amount_paid / 100, $invoice->currency);

                $lineItems = Invoice::retrieve($invoice->id)->lines->data;
                $products = [];
                $invoiceDescription = $invoice->description;

                /*    $trialStatus = 'No';
                $trialEndDate = null;

                //dd($invoice->subscription);
              //  dd(Subscription_Info::where($invoice->subscription));
                if ($invoice->subscription) {
                    //$subscription = Subscription_Info::retrieve($invoice->subscription);
                    if ($subscription->status === 'trialing') {
                        $trialStatus = 'Yes';
                        $trialEndDate = date('Y-m-d', $subscription->trial_end);
                    }
                }
                */

                foreach ($lineItems as $item) {
                    $products[] = [
                        'product_name' => $item->description,
                        'quantity' => $item->quantity,
                        'unit_price' => $this->formatCurrency($item->amount / 100, $invoice->currency),
                    ];

                    if (is_null($invoiceDescription) && $item->description) {
                        $invoiceDescription = $item->description;
                    }
                }

                $invoiceMonth = date('F Y', $invoice->created);

                $paymentHistory[] = [
                    'month' => $invoiceMonth,
                    'date' => date('Y-m-d', $invoice->created),
                    'amount' => $amountWithSymbol,
                    'status' => $invoice->status,
                    'description' => $invoiceDescription . ' / ' . $invoiceMonth,
                    'invoice_pdf' => $invoice->invoice_pdf,
                    'products' => $products,
                ];
            }
            return $paymentHistory;
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    private function formatCurrency($amount, $currencyCode)
    {
        $formatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($amount, strtoupper($currencyCode));
    }

    public function razorPayRedirect(Request $request)
    {
        try {

            $image            = setting('light_logo') && @is_file_exists(setting('light_logo')['original_image'])
                ? get_media(setting('light_logo')['original_image'])
                : getFileLink('80x80', []);
            $trx_id = $request->get('trx_id');
            $this->billingData($request);
            $plan             = $this->planRepository->find($request->plan_id);
            
            $subscriptionData = [
                'plan_id'         => $this->planRepository->getPGCredential($request->plan_id, 'razorpay_id'),
                'customer_notify' => 1,
                'total_count'     => 12,
            ];
            
            $response = Http::withBasicAuth(config('settings.razorpay_key'), config('settings.razorpay_secret'))
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post('https://api.razorpay.com/v1/subscriptions', $subscriptionData)
                ->json();

            // Check for error in the response
            if (isset($response['error'])) {
                return response()->json([
                    'error' => $response['error']['description'] ?? __('an_error_occurred'),
                    'code'  => $response['error']['code']        ?? null,
                ]);
            }

            $subscription_id = $response['id'];

            //-----------------------------------------------------
            // ✅ STORE subscription_id INTO USER TABLE
            //-----------------------------------------------------
            $user = auth()->user();
            $user->razor_subscription_plan_id = $subscription_id;
            $user->save();

            // Prepare data for successful response
            $data             = [
                'key'             => config('settings.razorpay_key'),
                'success'         => true,
                'name'            => setting('system_name'),
                'description'     => $plan->name,
                'image'           => $image,
                'subscription_id' => $response['id'],
                'callback_url'    => route('razor.pay.payment.success'),
                'prefill'         => [
                    'name'    => auth()->user()->name,
                    'email'   => auth()->user()->email,
                    'contact' => auth()->user()->phone,
                ],
                'notes'           => [
                    'address' => 'Subscribed to plan ' . $plan->name,
                ],
                'theme'           => [
                    'color' => setting('primary_color'),
                ],
            ];

            return view('client.subscription.checkout', [
                'subscription' => $response,
                'package' => $plan,
                'trx_id' => $trx_id,
            ]);
            //return response()->json($data);
        } catch (Exception $e) {
            //logError('razorPayRedirect: ', $e);

            return response()->json([
                'status' => false,
                'error'  => $e->getMessage(),
            ]);
        }
    }

    public function razorPaySuccess(Request $request): RedirectResponse
    {
        try {
            $subscription_id = $request->razorpay_subscription_id;
            $response        = Http::withBasicAuth(config('settings.razorpay_key'), config('settings.razorpay_secret'))->withHeaders([
                'Content-Type' => 'application/json',
            ])->get("https://api.razorpay.com/v1/subscriptions/$subscription_id")->json();
            $payment_details = $response;
            $billingInfo     = session('billing_info');
            $package         = $this->planRepository->find($billingInfo['plan_id']);
            
            if (! in_array($payment_details['status'], ['created', 'active'])) {
                // dd($payment_details);
                Toastr::error('invalid_request');

                return redirect()->back();
            }
            
           

            $this->subscriptionRepository->create($package, $billingInfo['trx_id'], $payment_details, $billingInfo, false, 'razor_pay');
            session()->forget('billing_info');
            
            Toastr::success('purchased_successfully');
            auth()->user()->plan_id = $package->id;
            auth()->user()->update();
            return redirect()->route('account.profile.billing')->with('success', __('purchased_successfully'));
        } catch (Exception $e) {
            Toastr::error($e->getMessage());
            //logError('Razor Pay Success: ', $e);

            return redirect()->back();
        }
    }

    //-- New Razorpay Integration Methods --//
    //-- Added by Amit Pawar --//

    public function razorWebhook(Request $request)
    {
        $data = $request->all();
        
        // ALWAYS log webhook
        SubscriptionTransactionLog::create([
            'description' => json_encode($data),
        ]);

        $event = $data['event'];

        if ($event == "subscription.charged") {
            $subscriptionId = $data['payload']['subscription']['entity']['id'];
            $paymentId = $data['payload']['payment']['entity']['id'];
            $amount = $data['payload']['payment']['entity']['amount'] / 100;

            $sub = Subscription_Info::where('trx_id', $subscriptionId)->first();
            if ($sub) {
                // extend expiry
                $sub->expire_date = now()->addMonth();
                $sub->save();
            }

            SubscriptionTransactionLog::create([
                'description' => json_encode([
                    'event' => 'recurring_payment',
                    'subscription_id' => $subscriptionId,
                    'payment_id' => $paymentId,
                    'amount' => $amount
                ]),
                'company_id' => $sub->company_id ?? null,
            ]);
        }

        if ($event == "subscription.paused") {
            Subscription_Info::where('trx_id', $data['payload']['subscription']['entity']['id'])
                ->update(['status' => 3]); // inactive
        }

        if ($event == "subscription.cancelled") {
            // Subscription_Info::where('trx_id', $data['payload']['subscription']['entity']['id'])
            //     ->update(['status' => 2, 'canceled_at' => now()]);
            $data = $request->payload['subscription']['entity'];
            $subscriptionId = $data['id'];
            $status = $data['status'];
            $currentEnd = $data['current_end'];

            $subscription              = Subscription_Info::find($request->sub_plan_id);
            $payment_method            = $request->payment_method;
            
            if (!$subscription) {
                // Subscription not found → log it or skip
                \Log::error("Subscription not found for ID: ".$subscriptionId);

                return response()->json([
                    'status' => false,
                    'message' => 'Subscription record not found'
                ], 404);
            }

            $subscription->canceled_at = now();
            $subscription->status      = 2;
            $subscription->update();

            auth()->user()->plan_id = null;
            auth()->user()->update();

            //Get Free plan information
            //$free_pricing_plan = intval(config('settings.free_pricing_id'));
            //$this->updateHubSpotList($free_pricing_plan);

            $log  = SubscriptionTransactionLog::create([
                'description' => __('you_have_canceled_your_subscription'),
                'company_id'  => auth()->user()->company_id
            ]);

            //return $subscription;
        }

        return redirect()->route('account.profile.billing')->with('success', __('webhook_processed_successfully'));
    }
    //-- End New Razorpay Integration Methods --//
}
