<?php

namespace App\Repositories\Client;

use App\Models\Company;
use App\Models\OneSignalToken;
use App\Models\Subscription;
use App\Models\Subscription_Info;
use App\Models\SubscriptionTransactionLog;
use App\Repositories\EmailTemplateRepository;
use App\Repositories\PlanRepository;
use App\Traits\SendMailTrait;
use App\Traits\SendNotification;
use App\Traits\SendWhatsAppNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Helpers\HubSpotHelper;
use Stripe\Stripe;
use Stripe\Invoice;
use Exception;

class SubscriptionRepository
{
    use SendMailTrait;
    use SendWhatsAppNotification;
    //use SendNotification;

    protected $emailTemplate;

    protected $planRepository;


    protected $hubSpotHelper;

    public function __construct(PlanRepository $planRepository, EmailTemplateRepository $emailTemplate, HubSpotHelper $hubSpotHelper)
    {
        $this->planRepository = $planRepository;
        $this->emailTemplate  = $emailTemplate;
        $this->hubSpotHelper = $hubSpotHelper;
        Stripe::setApiKey(config('settings.stripe_secret'));
    }

    //client
    public function create($plan, $trx_id, $payment_details, $billingInfo, $offline = false, $payment_method = 'stripe')
    {   

     //   dd($plan);
    //    dd($payment_details);
     //   dd($billingInfo);

        $is_offline = 0;
        $status       = 1;
        $billing_period = null;
        if ($offline) {
            $payment_method  = 'offline';
            $payment_details = json_encode(['payment_type' => 'offline']);
            
            $is_offline = 1;
            $status = 0;
        }
        $company       = auth()->user()->resolveCurrentCompany();
        $is_recurring = 0;
        $expire_date  = now();
        $trial_expire_date = "0000-00-00";
        $is_trial = 0;
        $billing_period = __('Monthly');

        if ($company->trial_used == 0 && session('trial_days')) {

            $trail_days = session('trial_days');
            $expire_date = now()->addDays($trail_days);
            $trial_expire_date = now()->addDays($trail_days);
            $is_trial = 1;
            $is_recurring = 1;

        } else {
            if ($plan->period == 1) {
                $expire_date  = now()->addMonths();
                $is_recurring = 1;
                $billing_period = __('Monthly');
            } elseif ($plan->period == 2) {
                $expire_date  = now()->addYears();
                $is_recurring = 1;
                $billing_period = __('Yearly');
            } elseif ($plan->period == 3) {
                $expire_date  = now()->addYears(100);
                $is_recurring = 0;
                $billing_period = 'Lifetime';
            }
        }

        $amount_paid = 0;
        $stripe_invoice_details = null;
        if (array_key_exists('invoice', $payment_details)) {
            $invoice_id = $payment_details['invoice'];
           // dd($invoice_id);
            $payment_info = $this->getPaymentDetailsByInvoiceId($invoice_id);
            $stripe_invoice_details = json_encode($payment_info);
            if ($payment_info && isset($payment_info['amount_without_currency'])) {
                $amount_paid = $payment_info['amount_without_currency'];
            }
        }

        $subscription = Subscription_Info::where('company_id', $company->id)->where('status', 1)->first();
        if ($subscription && $subscription->payment_method == 'stripe') {
            $this->cancelStripe($subscription);
            $subscription->status = 3;
            $subscription->save();
        } else if ($subscription) {
            $subscription->status = 3;
            $subscription->save();

            auth()->user()->plan_id = null;
            auth()->user()->plan_status = null;
            auth()->user()->update();
        }

        $data         = [
            'company_id'             => $company->id,
            'plan_id'                => $plan->id,
            'is_recurring'           => $is_recurring,
            'status'                 => $status,
            'purchase_date'          => now(),
            'expire_date'            => $expire_date,
            'trial_expire_date'      => $trial_expire_date,
            'plan_name'              => $plan->name,
            'price'                  => $plan->price,
            'is_trial'               => $is_trial,
            'amount_paid'            => $amount_paid,
            'stripe_invoice_details' => $stripe_invoice_details,
            'is_offline'             => $is_offline,
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
            'company'                => Company::find($company->id),
            'billing_name'           => $billingInfo['billing_name'],
            'billing_email'          => $billingInfo['billing_email'],
            'billing_address'        => $billingInfo['billing_address'],
            'billing_city'           => $billingInfo['billing_city'],
            'billing_state'          => $billingInfo['billing_state'],
            'billing_zip_code'       => $billingInfo['billing_zipcode'],
            'billing_country'        => $billingInfo['billing_country'],
            'billing_phone'          => $billingInfo['billing_phone'],
            'subject'                => __('package_subscription_confirmation') . ' ' . env('APP_NAME'),
        ];

        $company = auth()->user()->resolveCurrentCompany();
        $company->billing_name = $billingInfo['billing_name'];
        $company->billing_email = $billingInfo['billing_email'];
        $company->billing_address = $billingInfo['billing_address'];
        $company->billing_city = $billingInfo['billing_city'];
        $company->billing_state = $billingInfo['billing_state'];
        $company->billing_zip_code = $billingInfo['billing_zipcode'];
        $company->billing_country = $billingInfo['billing_country'];
        $company->billing_phone = $billingInfo['billing_phone'];
        if(session('used_coupon_id')){
            $company->coupon_used = $company->coupon_used + 1;
        }
        $company->trial_used = 1;
        $company->update();

        // Update HubSpot List for paid customers
        try {
            $this->updateHubSpotList($plan->id);

            if (isMailSetupValid()) {
                $this->sendmail(auth()->user()->email, 'emails.purchase_mail', $data);
            }

            $this->sendWhatsAppNotification($company->phone, auth()->user()->name, $plan->name, $billing_period, $expire_date);
        } catch (Exception $e) {
        }
        
        session()->forget('trial_plan_request');
        session()->forget('trial_session_id');
        session()->forget('billing_info');
        session()->forget('used_coupon_id');
        session()->forget('coupon_validation');
        session()->forget('coupon');
        session()->forget('coupon_id');
        session()->forget('trial_days');

        $log          = SubscriptionTransactionLog::create([
            'description' => __('you_have_purchased') . ' ' . $plan->name . ' ' . __('plan_successfully'),
            'company_id' => $company->id,
        ]);

        return Subscription_Info::create($data);
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

    private function formatCurrency($amount, $currencyCode)
    {
        $formatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($amount, strtoupper($currencyCode));
    }

    //admin
    public function store($request, $plan, $trx_id, $payment_details, $offline = false, $payment_method = 'stripe')
    {
         $status       = 1;
        if ($offline) {
            $payment_method  = 'offline';
            $payment_details = json_encode(['payment_type' => 'offline']);
            $status          = 1;
        }
        $company       = Company::where('id', $request->company_id)->first();
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
            $expire_date  = null;
            $is_recurring = 0;
            $billing_period = 'Lifetime';
        }

        $subscription = Subscription_Info::where('company_id', $company->id)->where('status', 1)->first();
        if ($subscription) {
            $subscription->status = 2;
            $subscription->save();
        }

        $data         = [
            'company_id'             => $company->id,
            'plan_id'                => $plan->id,
            'is_recurring'           => $is_recurring,
            'status'                 => $status,
            'purchase_date'          => now(),
            'expire_date'            => $expire_date,
            'price'                  => $request->amount,
            'package_type'           => $plan->period,
            'contact_limit'          => $plan->contact_limit,
            'campaign_limit'         => $plan->campaigns_limit,
            'campaign_remaining'     => $plan->campaigns_limit,
            'conversation_limit'     => $plan->conversation_limit,
            'conversation_remaining' => $plan->conversation_limit,
            'team_limit'             => $plan->team_limit,
            'max_chatwidget'         => $plan->max_chatwidget,
            'max_flow_builder'       => $plan->max_flow_builder ?? 0,
            'max_bot_reply'          => $plan->max_bot_reply ?? 0,
            'trx_id'                 => $trx_id,
            'payment_method'         => $payment_method,
            'payment_details'        => $payment_details,
            'company'                 => Company::find($company->id),
        ];
        SubscriptionTransactionLog::create([
            'description' => 'Admin has purchased ' . $plan->name . ' plan for you',
            'company_id'                                                   => $company->id
        ]);

        return Subscription_Info::create($data);
    }

    public function subscribeListStatus($request, $id)
    {
        $subscribe         = Subscription_Info::findOrfail($id);
        $subscribe->status = $request['status'];
        if ($request['status'] == 2) {
            $payment_method         = $subscribe->payment_method;
            if ($payment_method == 'stripe') {
                $this->cancelStripe($subscribe);
            } elseif ($payment_method == 'paddle') {
                $this->cancelPaddle($subscribe);
            } elseif ($payment_method == 'paypal') {
                $this->cancelPaypal($subscribe);
            }
            $subscribe->canceled_at = now();
        }
        $status            = __('pending');
        if ($request['status'] == 1) {
            $status = __('active');
        } elseif ($request['status'] == 2) {
            $status = __('cancelled');
        } elseif ($request['status'] == 3) {
            $status = __('rejected');
        }
        $msg               = __('subscription_status_updated', ['status' => $status]);

        return $subscribe->save();
    }

    public function updateSubscriptionLimits($subscriptionId, $newLimits)
    {
        $subscription = Subscription_Info::findOrFail($subscriptionId);
        $subscription->contact_limit          += intval($newLimits['new_contacts_limit']);
        $subscription->campaign_remaining     += intval($newLimits['new_campaigns_limit']);
        $subscription->campaign_limit         += intval($newLimits['new_campaigns_limit']);
        $subscription->conversation_remaining += intval($newLimits['new_conversation_limit']);
        $subscription->conversation_limit     += intval($newLimits['new_conversation_limit']);
        $subscription->team_limit             += intval($newLimits['new_team_limit']);
        $subscription->max_chatwidget         += intval($newLimits['new_max_chatwidget']);
        $subscription->max_flow_builder      += intval($newLimits['new_max_flow_builder']);
        $subscription->max_bot_reply         += intval($newLimits['new_max_bot_reply']);

        $log          = SubscriptionTransactionLog::create([
            'description' => 'Admin update some credit in your Subscription',
            'company_id' => $subscription->company_id
        ]);
        $subscription->save();

        return $subscription;
    }

    public function cancelSubscription($id)
    {
        $subscription              = Subscription_Info::find($id);

        $payment_method            = $subscription->payment_method;

        $this->cancelStripe(subscription: $subscription);

        $subscription->canceled_at = now();
        $subscription->status      = 2;
        $subscription->update();

        auth()->user()->plan_id = null;
        auth()->user()->update();

        //Get Free plan information
        $free_pricing_plan = intval(config('settings.free_pricing_id'));
        $this->updateHubSpotList($free_pricing_plan);

        $log                       = SubscriptionTransactionLog::create([
            'description' => __('you_have_canceled_your_subscription'),
            'company_id'                                                                => auth()->user()->company_id
        ]);

        return $subscription;
    }

    public function stopRecurring($id)
    {
        $subscription               = Subscription_Info::find($id);

        $payment_method             = $subscription->payment_method;

        if ($payment_method == 'stripe') {
            $this->cancelStripe($subscription);
        } elseif ($payment_method == 'paddle') {
            $this->cancelPaddle($subscription);
        } elseif ($payment_method == 'paypal') {
            $this->cancelPaypal($subscription);
        }
        $cancel_date                = Carbon::parse($subscription->purchase_date);
        if ($subscription->package_type == 'monthly') {
            $cancel_date = $cancel_date->addMonth();
        } elseif ($subscription->package_type == 'yearly') {
            $cancel_date = $cancel_date->addYear();
        }
        $subscription->canceled_at  = $cancel_date;
        $subscription->is_recurring = 0;

        if (auth()->user()->user_type == 'admin') {
            $log = SubscriptionTransactionLog::create([
                'description' => 'admin stop your recurring',
                'company_id'                                          => $subscription->company_id
            ]);
        } else {
            $log = SubscriptionTransactionLog::create([
                'description' => 'you stop your recurring',
                'company_id'                                          => $subscription->company_id
            ]);
        }

        $subscription->save();

        return $subscription;
    }

    public function enableRecurring($id)
    {
        $subscription               = Subscription_Info::find($id);

        $payment_method             = $subscription->payment_method;

        if ($payment_method == 'stripe') {
            $this->cancelStripe($subscription);
        } elseif ($payment_method == 'paddle') {
            $this->cancelPaddle($subscription);
        } elseif ($payment_method == 'paypal') {
            $this->cancelPaypal($subscription);
        }
        $cancel_date                = Carbon::parse($subscription->purchase_date);

        if ($subscription->package_type == 'monthly') {
            $cancel_date = $cancel_date->addMonth();
        } elseif ($subscription->package_type == 'yearly') {
            $cancel_date = $cancel_date->addYear();
        }
        $subscription->canceled_at  = $cancel_date;
        $subscription->is_recurring = 1;
        $log                        = SubscriptionTransactionLog::create([
            'description' => 'You enable subscription recurring',
            'company_id'                                                                 => $subscription->company_id
        ]);
        $subscription->save();

        return $subscription;
    }

    public function cancelStripe($subscription)
    {
        $stripe_subscript_id = getArrayValue('subscription', $subscription->payment_details);
        $response            = [];

        if ($stripe_subscript_id) {
            $headers  = [
                'Authorization' => 'Basic ' . base64_encode(config('settings.stripe_secret') . ':'),
                'Content-Type'  => 'application/x-www-form-urlencoded',
            ];

            $data     = [
                'invoice_now' => 'false',
            ];
            $response = httpRequest('https://api.stripe.com/v1/subscriptions/' . $stripe_subscript_id, $data, $headers, true, 'DELETE');
        }

        return $response;
    }

    public function cancelPaddle($subscription)
    {
        $transaction_id  = $subscription->payment_details['transaction_id'];

        $headers         = [
            'Authorization' => 'Bearer ' . setting('paddle_api_key'),
        ];
        if (setting('is_paddle_sandbox_mode_activated')) {
            $base_url = 'https://sandbox-api.paddle.com/';
        } else {
            $base_url = 'https://api.paddle.com/';
        }
        $data            = [
            'effective_from' => 'next_billing_period',
        ];
        $response        = httpRequest($base_url . "transactions/$transaction_id", $data, $headers, false, 'GET');
        $subscription_id = $response['data']['subscription_id'];

        return httpRequest($base_url . "subscriptions/$subscription_id/cancel", $data, $headers);
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

    public function cancelPaypal($subscription)
    {
        if (setting('is_paypal_sandbox_mode_activated')) {
            $base_url = 'https://api-m.sandbox.paypal.com';
        } else {
            $base_url = 'https://api-m.paypal.com';
        }
        $paypal_subscription_id = $subscription->payment_details['id'];
        $headers                = [
            'Content-Type'  => 'application/json',
            'Authorization' => $this->paypalTokenGenerator($base_url),
        ];

        $data                   = [
            'reason' => 'stopped by admin',
        ];

        return httpRequest($base_url . '/v1/billing/subscriptions/' . $paypal_subscription_id . '/cancel', $data, $headers);
    }

    public function updateValidity($data, $id)
    {
        $subscription                  = Subscription_Info::find($id);

        $date                          = '';
        if ($data['interval'] == 'day') {
            $date = Carbon::parse($subscription->expire_date)->addDays($data['time']);
        } elseif ($data['interval'] == 'week') {
            $date = Carbon::parse($subscription->expire_date)->addWeeks($data['time']);
        } elseif ($data['interval'] == 'month') {
            $date = Carbon::parse($subscription->expire_date)->addMonths($data['time']);
        } elseif ($data['interval'] == 'year') {
            $date = Carbon::parse($subscription->expire_date)->addYears($data['time']);
        }

        $payment_details               = $subscription->payment_details;
        $payment_method                = $subscription->payment_method;
        if ($payment_method == 'stripe') {
            $payment_details = $this->updateStripe($subscription, $date->timestamp);
        } elseif ($payment_method == 'paddle') {
            //  $payment_details = $this->updatePaddle($subscription);
        } elseif ($payment_method == 'paypal') {
            // $payment_details = $this->updatePaypal($subscription);
        }
        $subscription->payment_details = $payment_details;
        $subscription->expire_date     = $date;
        $subscription->save();

        return $subscription;
    }

    public function updateStripe($subscription, $date)
    {
        $this->cancelStripe($subscription);

        $headers = [
            'Authorization' => 'Basic ' . base64_encode(config('settings.stripe_secret') . ':'),
            'Content-Type'  => 'application/x-www-form-urlencoded',
        ];
        $url     = 'https://api.stripe.com/v1/subscriptions';

        $fields  = [
            'customer'             => $subscription->payment_details['customer'],
            'currency'             => 'USD',
            'items'                => [
                [
                    'price'    => $this->planRepository->getPGCredential($subscription->plan_id, 'stripe'),
                    'quantity' => 1,
                ],
            ],
            'billing_cycle_anchor' => $date,
        ];

        return httpRequest($url, $fields, $headers, true);
    }

    // Update Hubspot subscription listing
    public function updateHubSpotList($plan_id = null)
    {
        $contactId =  auth()->user()->hubspot_contactId;
        $free_pricing_plan = intval(config('settings.free_pricing_id'));
        try {
            //Only add to Hubspot for paid subscriptions
            if ($plan_id != $free_pricing_plan) {
                //Add user to Hubspot paid subscription list
                $paidListId = env('HUBSPOT_PAID_SUBSCRIPTION_LIST_ID');
                $freeListId = env('HUBSPOT_FREE_SUBSCRIPTION_LIST_ID');

                if (!empty($contactId) && !empty($paidListId) && !empty($freeListId)) {
                    $this->hubSpotHelper->removeContactFromList($freeListId, $contactId);
                    $this->hubSpotHelper->addContactToList($paidListId, $contactId);
                }
            } else {
                //Add user to Hubspot free subscription list
                $paidListId = env('HUBSPOT_PAID_SUBSCRIPTION_LIST_ID');
                $freeListId = env('HUBSPOT_FREE_SUBSCRIPTION_LIST_ID');

                if (!empty($contactId) && !empty($paidListId) && !empty($freeListId)) {
                    $this->hubSpotHelper->removeContactFromList($paidListId, $contactId);
                    $this->hubSpotHelper->addContactToList($freeListId, contactId: $contactId);
                }
            }
        } catch (Exception $e) {
        }
    }
}
