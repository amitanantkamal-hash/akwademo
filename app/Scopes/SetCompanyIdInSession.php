<?php

namespace App\Scopes;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Modules\Wpbox\Traits\Whatsapp;

class SetCompanyIdInSession
{
    use Whatsapp;

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $user = User::find($event->user->id);
        
        // Check if user is active
        if (!$user->is_active) {
            Log::warning('Inactive user attempted login', [
                'user_id' => $user->id,
                'email' => $user->email,
                'attempted_at' => now()
            ]);

            // Logout the user immediately
            Auth::logout();
            Session::flush();

            // Optional: You can throw an exception or redirect here
            // throw new \Exception('User account is deactivated.');
            return;
        }

        // Update last login time
        try {
            $user->update([
                'last_logged_in_on' => now(),
            ]);
            
            Log::info('User login recorded', [
                'user_id' => $user->id,
                'email' => $user->email,
                'last_login' => now()
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update last login time', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }

        $vendor = $user->company;

        if ($vendor) {
            session([
                'company_id' => $vendor->id,
                'company_currency' => $vendor->currency,
                'company_convertion' => $vendor->do_covertion,
                'user_last_login' => $user->last_logged_in_on,
                'user_is_active' => $user->is_active, 
            ]);

            Session::put('user_data', [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_active' => $user->is_active,
                'last_login' => $user->last_logged_in_on,
                'login_time' => now(),
            ]);

            $company = $user->resolveCurrentCompany();
            if ($company && $company->getConfig('whatsapp_settings_done', 'no') == 'yes') {
                $accessinfo = $this->access_connect(
                    $company->getConfig('whatsapp_business_account_id'),
                    $company->getConfig('whatsapp_permanent_access_token'),
                    $company->getConfig('whatsapp_phone_number_id')
                );

                if (!empty($accessinfo)) {
                    $company->setConfig('verified_name', $accessinfo['verified_name'] ?? '');
                    $company->setConfig('code_verification_status', $accessinfo['code_verification_status'] ?? '');
                    $company->setConfig('display_phone_number', $accessinfo['display_phone_number'] ?? '');
                    $company->setConfig('quality_rating', $accessinfo['quality_rating'] ?? '');
                    $company->setConfig('profile_picture_url', $accessinfo['profile_picture_url'] ?? '');
                    $company->setConfig('name_status', $accessinfo['name_status'] ?? '');
                    $company->setConfig('messaging_limit_tier', $accessinfo['messaging_limit_tier'] ?? '');
                    $company->setConfig('can_send_message', $accessinfo['can_send_message'] ?? '');
                    $company->setConfig('last_onboarded_time', $accessinfo['last_onboarded_time'] ?? '');
                }
            }
        }
    }
}