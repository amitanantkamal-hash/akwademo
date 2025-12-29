<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PendingUser;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use App\Helpers\StaticHelper;
use Carbon\Carbon;

class VerifyPendingUserController extends Controller
{
    public function verify($token)
    {
        $pending = PendingUser::where('email_verification_token', $token)->first();

        if (!$pending) {
            abort(404, "Invalid verification token.");
        }

        DB::beginTransaction();

        $userData = [
            'name' => $pending->name,
            'name_company' => $pending->name_company,
            'email' => $pending->email,
            'password' => $pending->password,
            'phone' => $pending->phone,
            'is_optin' => $pending->is_optin,
            'is_optin' => isset($input['is_optin']) && $input['is_optin'] === 'on' ? 1 : 0,
        ];

        if (env('OTP_VERIFICATION') == true) {
            $otp = rand(100000, 999999);
            $userData['otp'] = $otp;
            $userData['otp_sent_at'] = now();
            $userData['is_otp_verified'] = 0; // Initially not verified
        } else {
            $userData['is_otp_verified'] = 1;
        }

        // Create the user with the conditional data
        $user = User::create($userData);
        $user->plan_id = config('settings.free_pricing_id');
        $user->trial_ends_at = Carbon::now()->addDays(config('settings.free_trail_days'));
        $user->free_plan_used = true;
        $user->save();

        $user->assignRole('owner');
 
        //Create company
        $lastCompanyId = DB::table('companies')->insertGetId([
            'name' => $pending->name,
            'subdomain' => strtolower(preg_replace('/[^A-Za-z0-9]/', '', $pending->name)),
            'user_id' => $user->id,
            'created_at' => now(),
            'updated_at' => now(),
            'phone' => $pending->phone, // Add 'phone' to the company creation
            'logo' => asset('uploads') . '/default/no_image.jpg',
        ]);

        if (env('OTP_VERIFICATION') == true) {
            StaticHelper::sendWA_OTP($otp, $pending->phone);
        }
        $user->company_id = $lastCompanyId;
        $user->update();

        // Send welcome email
        Mail::to($user->email)->send(new WelcomeMail($user));

        // Delete pending user
        $pending->delete();

        DB::commit();

        return redirect()->route('verify-otp')
            ->with('status', 'Email Verified. OTP sent to your phone.');
    }
}
