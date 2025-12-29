<?php

namespace App\Console\Commands;

use App\Models\Subscription_Info;
use Illuminate\Console\Command;
use Stripe\Stripe;
use Stripe\Subscription;
use App\Models\User;
use Carbon\Carbon;
use App\Helpers\HubSpotHelper;
use Exception;
use HubSpot\Client\Webhooks\Model\SubscriptionResponse;

class CheckAndUpdateSubscriptions extends Command
{
    protected $signature = 'subscriptions:check';
    protected $hubSpotHelper;
    protected $description = 'Check and update customer subscriptions';

    public function __construct(HubSpotHelper $hubSpotHelper)
    {
        $this->hubSpotHelper = $hubSpotHelper;
        parent::__construct();
    }

    public function handle()
    {
        Stripe::setApiKey(config('settings.stripe_secret'));

        $company             = auth()->user()->resolveCurrentCompany();

        $this->checkAndUpdateUserSubscription($company);

        $this->info('Subscription check and update completed.');
    }

    private function checkAndUpdateUserSubscription($company)
    {
        try {
            $subscriptions = Subscription::all([
                'customer' => $company->stripe_customer_id,
                'status' => 'active',
                'limit' => 1,
            ]);


            $active_subscription = Subscription_Info::where('company_id', $company->id)->first();

            if (empty($subscriptions->data)) {
                // No active subscription found, set the status to 3 (cancelled)
                $active_subscription->canceled_at = now();
                $active_subscription->status      = 2;
                $active_subscription->update();

                auth()->user()->plan_id = null;
                auth()->user()->update();

                $free_pricing_plan = intval(config('settings.free_pricing_id'));
                $this->updateHubSpotList($free_pricing_plan);

                return;
            }

            // Get the active subscription from Stripe
            $subscription = $subscriptions->data[0];
            $currentPlan = $subscription->plan->id;
            $currentPeriodEnd = Carbon::createFromTimestamp($subscription->current_period_end);

            $storedPeriodEnd = Carbon::parse($active_subscription->expire_date);

            if ($currentPeriodEnd->gt($storedPeriodEnd)) {

                $active_subscription->updated_at = now();
                $active_subscription->expire_date = $currentPeriodEnd;
                $active_subscription->update();
                
            }
        } catch (\Exception $e) {
            //\Log::error("Error updating subscription for company {$company->id}: {$e->getMessage()}");
        }
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
         } catch (\Exception $e) {
         }
     }
}
