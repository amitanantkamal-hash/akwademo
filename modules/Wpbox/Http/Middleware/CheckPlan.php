<?php

namespace Modules\Wpbox\Http\Middleware;

use App\Models\Plans;
use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Subscription_Info;

class CheckPlan
{
    public function handle(Request $request, Closure $next)
    {
        // If the user is not authenticated, redirect to login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Skip check for admin users
        if (Auth::user()->hasRole('admin')) {
            return $next($request);
        }

        // Get the company
        $company = Auth::user()->resolveCurrentCompany();

        // 1. Check company subscription first
        $active_subscription = Subscription_Info::where('company_id', $company->id)->where('purchase_date', '<=', now())->where('expire_date', '>=', now())->where('status', '!=', 3)->latest()->first();

        // If subscription exists
        if ($active_subscription) {
            // Check expiration for non-lifetime packages
            if ($active_subscription->package_type != 3) {
                $expireDate = Carbon::parse($active_subscription->expire_date);

                if (Carbon::now()->greaterThan($expireDate)) {
                    return redirect(route('subscription.info'))->withError(__('Your subscription has expired. Please renew to continue using the service.'));
                }
            }
        }
        // 2. If no subscription, check user trial period
        else {
            $user = Auth::user();

            // Check if trial period exists and has ended
            if ($user->trial_ends_at && Carbon::now()->greaterThan($user->trial_ends_at)) {
                return redirect(route('subscription.info'))->withError(__('Your trial period has ended. Please subscribe to continue using the service.'));
            }

            // If no subscription AND no valid trial period
            if (!$user->trial_ends_at || Carbon::now()->greaterThan($user->trial_ends_at)) {
                return redirect(route('subscription.info'))->withError(__('No active subscription or trial period. Please subscribe to continue.'));
            }
        }

        // Continue with plan limit checks
        if (Auth::user()->hasRole('owner')) {
            $plan = Plans::find(Auth::user()->mplanid());
        } else {
            $plan = Plans::find(Auth::user()->company->user->mplanid());
        }

        if (!$plan) {
            return redirect(route('subscription.info'))->withError(__('There is no plan assigned to your account. Please contact the administrator.'));
        }

        $daysToCheck = 30;
        $allowedCampaigns = intval($plan->limit_items);
        $allowedMessages = intval($plan->limit_views);
        $allowedContacts = intval($plan->limit_orders);

        // Adjust for yearly plans
        if ($plan->period == 2) {
            $daysToCheck = 365;
            $allowedCampaigns = intval($plan->limit_items) * 12;
            $allowedMessages = intval($plan->limit_views) * 12;
            $allowedContacts = intval($plan->limit_orders) * 12;
        }

        // Get usage counts
        $messagesCount = DB::table('messages')
            ->where('created_at', '>=', Carbon::now()->subDays($daysToCheck))
            ->where('company_id', $company->id)
            ->whereNotNull('fb_message_id')
            ->count();

        $campaignsCount = DB::table('wa_campaings')
            ->where('created_at', '>=', Carbon::now()->subDays($daysToCheck))
            ->where('company_id', $company->id)
            ->count();

        $contactsCount = DB::table('contacts')->where('company_id', $company->id)->count();

        // Check limits
        if ($allowedMessages > 0 && $messagesCount >= $allowedMessages) {
            return redirect(route('subscription.info'))->withError(__('You have exceeded the message limit for your plan'));
        }

        if ($allowedCampaigns > 0 && $campaignsCount >= $allowedCampaigns) {
            return redirect(route('subscription.info'))->withError(__('You have exceeded the campaign limit for your plan'));
        }

        if ($allowedContacts > 0 && $contactsCount >= $allowedContacts) {
            return redirect(route('subscription.info'))->withError(__('You have exceeded the contact limit for your plan'));
        }

        return $next($request);
    }
}
