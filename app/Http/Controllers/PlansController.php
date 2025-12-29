<?php

namespace App\Http\Controllers;

use Akaunting\Module\Facade as Module;
use App\Models\Plans;
use App\Models\Subscription_Info;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Laravel\Cashier\Exceptions\PaymentActionRequired;
use Laravel\Cashier\Exceptions\PaymentFailure;
use Stripe\Exception\InvalidRequestException;
use App\Helpers\HubSpotHelper;
use App\Models\Company;
use App\Models\SubscriptionTransactionLog;
use App\Repositories\Client\SubscriptionRepository;
use HubSpot\Client\Webhooks\Model\SubscriptionResponse;
use Illuminate\Support\Str;
use App\Traits\SendMailTrait;
use App\Traits\SendWhatsAppNotification;



class PlansController extends Controller
{
    use SendMailTrait;
    use SendWhatsAppNotification;

    protected $hubSpotHelper;

    protected $subscriptionRepository;

    public function __construct(HubSpotHelper $hubSpotHelper, SubscriptionRepository $subscriptionRepository)
    {
        $this->hubSpotHelper = $hubSpotHelper;
        $this->subscriptionRepository = $subscriptionRepository;
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

        return view('plans.current', $data);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Plans $plans): View
    {
        $this->adminOnly();
        if (! $this->isExtended()) {
            return view('plans.extended');
        }

        return view('plans.index', ['plans' => $plans->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->adminOnly();
        $theSelectedProcessor = strtolower(config('settings.subscription_processor', 'stripe'));

        return view('plans.create', [
            'allplugins' => $this->getAllPlugins(),
            'theSelectedProcessor' => $theSelectedProcessor
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->adminOnly();
        //Validate request
        $rules = [
            'name' => ['required'],
            'price' => ['numeric', 'required'],
            'description' => ['required'],
            'features' => ['required'],
            'stripe_id' => ['sometimes'],
            //'limit_items'=>['numeric','required'],
            //'limit_orders'=>['numeric','required']
        ];

        $request->validate($rules);

        $plan = new Plans;
        $plan->name = strip_tags($request->name);
        $plan->price = strip_tags($request->price);
         //Campaigns limit
         $plan->limit_items = strip_tags($request->limit_items);
         $plan->campaigns_limit = strip_tags($request->limit_items);
         //Messages limit
         $plan->limit_views = strip_tags($request->limit_views);
         //Conversation Limit
         $plan->conversation_limit = strip_tags($request->conversation_limit);
         //Contacts limit
         $plan->contact_limit = strip_tags($request->contact_limit);
         $plan->limit_orders = strip_tags($request->contact_limit);
         //Team limit
         $plan->team_limit = strip_tags($request->team_limit);
         $plan->max_chatwidget = 0;
         //Flow Builder Limit
         $plan->max_flow_builder = strip_tags($request->max_flow_builder);
         //Bot Reply Limit
         $plan->max_bot_reply = strip_tags($request->max_bot_reply); 

        if (isset($request->subscribe)) {
            foreach ($request->subscribe as $key => $value) {
                $plan->$key = strip_tags($value);
            }
        }

        if (config('settings.enable_credits')) {
            $plan->credit_amount = strip_tags($request->credit_amount);
        }

         //Default stripe
         if (isset($request->stripe_id)) {
            $plan->stripe_id = $request->stripe_id;
        }

        $plan->description = $request->description;
        $plan->features = $request->features;

        $plan->period = $request->period == 'monthly' ? 1 : ($request->period == 'lifetime' ? 3 : 2);

        $plan->status = $request->plan_status;
        $plan->trial_status = $request->trial_status;
        $plan->trial_days = strip_tags($request->trial_days);

        $plan->save();

        $this->updatePlanPlugins($plan, $request->pluginsSelector);

        return redirect()->route('plans.index')->withStatus(__('Plan successfully created!'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        //
    }

    private function getAllPlugins()
    {
        $plugins = [];
        foreach (Module::all() as $key => $module) {
            if (is_array($module->get('vendor_fields'))) {
                array_push($plugins, $module);
            }
        }

        return $plugins;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit(Plans $plan): View
    {
        $this->adminOnly();
        $theSelectedProcessor = strtolower(config('settings.subscription_processor', 'Stripe'));

        return view(
            'plans.edit',
            [
                'allplugins' => $this->getAllPlugins(),
                'plan' => $plan,
                'theSelectedProcessor' => $theSelectedProcessor,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     */
    public function update(Request $request, Plans $plan): RedirectResponse
    {
       // dd($request->all());
        $this->adminOnly();
        $plan->name = strip_tags($request->name);
        $plan->price = strip_tags($request->price);
        //Campaigns limit // few column are from older versions just maintaining for future versions
        $plan->limit_items = strip_tags($request->limit_items);
        $plan->campaigns_limit = strip_tags($request->limit_items);
        //Messages limit
        $plan->limit_views = strip_tags($request->limit_views);
        //Conversation Limit
        $plan->conversation_limit = strip_tags($request->conversation_limit);
        //Contacts limit
        $plan->contact_limit = strip_tags($request->contact_limit);
        $plan->limit_orders = strip_tags($request->contact_limit);
        //Team limit
        $plan->team_limit = strip_tags($request->team_limit);
        $plan->max_chatwidget = 0;
        //Flow Builder Limit
        $plan->max_flow_builder = strip_tags($request->max_flow_builder);
        //Bot Reply Limit
        $plan->max_bot_reply = strip_tags($request->max_bot_reply); 

        //Subscriptions plans
        if (isset($request->subscribe)) {
            foreach ($request->subscribe as $key => $value) {
                $plan->$key = strip_tags($value);
            }
        }

        //Default stripe
        if (isset($request->stripe_id)) {
            $plan->stripe_id = $request->stripe_id;
        }

        if (config('settings.enable_credits')) {
            $plan->credit_amount = strip_tags($request->credit_amount);
        }

        $plan->period = $request->period == 'monthly' ? 1 : ($request->period == 'lifetime' ? 3 : 2);
        $plan->status = $request->plan_status;

        $plan->trial_status = $request->trial_status;
        $plan->trial_days = strip_tags($request->trial_days);

        $plan->enable_ordering = $request->ordering == 'enabled' ? 1 : 2;

        $plan->description = $request->description;
        $plan->features = $request->features;

        $plan->update();

        $this->updatePlanPlugins($plan, $request->pluginsSelector);

        return redirect()->route('plans.index')->withStatus(__('Plan successfully updated!'));
    }

    private function updatePlanPlugins($plan, $pluginsSelector)
    {
        if ($pluginsSelector) {
            $plan->setConfig('plugins', json_encode($pluginsSelector));
        } else {
            //Set to null
            $plan->setConfig('plugins', null);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy(Plans $plan): RedirectResponse
    {
        $this->adminOnly();
        $plan->delete();

        return redirect()->route('plans.index')->withStatus(__('Plan successfully deleted!'));
    }

    public function subscribe3dStripe(Request $request, Plans $plan, User $user): RedirectResponse
    {
        if ($request->success . '' == 'true') {
            //Assign user to plan
            $user->plan_id = $plan->id;
            $user->cancel_url = route('plans.cancel');

            $user->update();

            return redirect()->route('plans.current')->withStatus(__('Plan update!'));
        } else {
            return redirect()->route('plans.current')->withEror($request->message)->withInput();
        }
    }

    public function cancelStripeSubscription(): RedirectResponse
    {
        auth()->user()->subscription('main')->cancelNow();
        auth()->user()->cancel_url = '';
        auth()->user()->plan_id = intval(config('settings.free_pricing_id'));
        auth()->user()->update();

        $this->updateHubSpotList(auth()->user()->plan_id);

        return redirect()->route('plans.current')->withError(__('Subscription canceled'));
    }

    public function updateHubSpotList($plan_id = null)
    {

        $contactId =  auth()->user()->hubspot_contactId;
        $free_pricing_plan = intval(config('settings.free_pricing_id'));
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
    }

    public function subscribe(Request $request): RedirectResponse
    {
        $plan = Plans::findOrFail($request->plan_id);

        if (config('settings.subscription_processor') == 'Stripe') {
            $plan_stripe_id = $plan->stripe_id;
            //Shold we do a swap
            try {
                if (auth()->user()->subscribed('main')) {

                    //SWAP
                    auth()->user()->subscription('main')->swap($plan_stripe_id);
                    auth()->user()->cancel_url = route('plans.cancel');
                    $this->updateHubSpotList($plan_stripe_id);
                } else {
                    //NEW Stripe subscription
                    $payment_stripe = auth()->user()->newSubscription('main', $plan_stripe_id)->create($request->stripePaymentId, []);
                    auth()->user()->cancel_url = route('plans.cancel');
                    $this->updateHubSpotList($plan_stripe_id);
                }
            } catch (PaymentActionRequired $e) {
                //On PaymentActionRequired - send the checkout link
                $paymentRedirect = route('cashier.payment', [$e->payment->id, 'redirect' => route('plans.subscribe_3d_stripe', ['plan' => $plan->id, 'user' => auth()->user()->id])]);

                return redirect($paymentRedirect);
            } catch (InvalidRequestException $e) {
                //Display the message
                //On PaymentActionRequired - send the checkout link
                $paymentRedirect = route('cashier.payment', [$e->payment->id, 'redirect' => route('plans.subscribe_3d_stripe', ['plan' => $plan->id, 'user' => auth()->user()->id])]);

                return redirect($paymentRedirect);
            } catch (IncompletePayment $e) {
                //On IncompletePayment - SCA - send the checkout link
                $paymentRedirect = route('cashier.payment', [$e->payment->id, 'redirect' => route('plans.subscribe_3d_stripe', ['plan' => $plan->id, 'user' => auth()->user()->id])]);

                return redirect($paymentRedirect);
            }

            //PaymentFailure
            catch (PaymentFailure $e) {
                //On Fail delete order and inform user
                return redirect()->route('plans.current')->withError(__('Payment Failure'));
            }
        }

        //Assign user to plan
        auth()->user()->plan_id = $plan->id;
        auth()->user()->update();

        return redirect()->route('plans.current')->withStatus(__('Plan update!'));
    }

    public function adminupdate(Request $request): RedirectResponse
    {
        $this->adminOnly();
        $user = User::findOrFail($request->user_id);
        $this->addPlanToCompany($request->plan_id, $user);
        $user->plan_id = $request->plan_id;
        $user->plan_status = 'set_by_admin';
        $user->update();

        return redirect()->route('admin.companies.edit', $request->company_id)->withStatus(__('Plan successfully updated.'));
    }

    public function addPlanToCompany($plan_id = null, $user)
    {
        $status        = 1;
        $company       = $user->company;
        $plan = Plans::where('id', $plan_id)->first();

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
        
        $subscription = Subscription_Info::where('company_id', $company->id)->where('status', 1)->first();
        if ($subscription && $subscription->payment_method == 'stripe') {
            $this->subscriptionRepository->cancelStripe($subscription);
            $subscription->status = 3;
            $subscription->save();
        } else if ($subscription) {
            $subscription->status = 3;
            $subscription->save();
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
            'amount_paid'            => $plan->price,
            'stripe_invoice_details' => null,
            'is_offline'             => 1,
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
            'payment_method'         => 'set_by_admin',
            'payment_details'        => '',
            'company'                => Company::find($company->id),
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

        if (isMailSetupValid()) {
            $this->sendmail($user->email, 'emails.purchase_mail', $data);
        }

        $this->sendWhatsAppNotification($company->phone, $user->name, $plan->name, $billing_period, $expire_date);

        $log          = SubscriptionTransactionLog::create([
            'description' => __('plan_assigned_to_user_by_admin') . ' ' . $plan->name . ' ' . __('plan'),
            'company_id' => $company->id,
        ]);

        // Update HubSpot List for paid customers
        $this->updateHubSpotList($plan->id);
        return Subscription_Info::create($data);
       // dd($data);
        // try{
        // return Subscription_Info::create($data);
        // }
        // catch(\Exception $e){

        //     dd($e);

        // }
    }

    public function isExtended()
    {
        //First check if pure saas
        if (config('settings.makePureSaaS')) {
            //Do a check if the APPs download code is set
            if (md5(config('settings.extended_license_download_code', '')) == 'd0398556dbecac06370bdc8baec559a9' || config('settings.is_demo', false)) {
                return true;
            } else {
                return true;
            }
        } else {
            //Old way
            return true;
        }
    }
}
