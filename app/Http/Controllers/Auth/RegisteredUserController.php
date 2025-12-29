<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\PendingUser;
use App\Mail\VerifyPendingUserMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Laravel\Jetstream\Jetstream;
use App\Helpers\StaticHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    protected function passwordRules()
    {
        return ['required', 'string', Password::min(8)->letters()->numbers()->mixedCase(), 'confirmed'];
    }

    public function store(Request $request)
    {
        $input = $request->all();
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:pending_users'],
            'phone' => ['required', 'string', 'max:255', 'unique:pending_users'],
            'name_company' => ['required', 'string', 'max:255'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $verificationToken = Str::random(64);
        
        $phone = '+' . $input['country_code'] . trim($input['phone']);
        $phone = trim(preg_replace('/[\s]/', '', $phone));
            
        $pendingUser = PendingUser::create([
            'name'          => $input['name'],
            'name_company'  => $input['name_company'],
            'email'         => $input['email'],
            'password'      => Hash::make($input['password']),
            'phone'         => $phone,
            'country_code'  => $input['country_code'],
            'is_optin'      => isset($input['is_optin']) && $input['is_optin'] === 'on' ? 1 : 0,
            'email_verification_token' => $verificationToken,
            'token_expires_at'   => now()->addHours(24),
        ]);

        
        // Send email verification
        Mail::to($pendingUser->email)->send(new VerifyPendingUserMail($pendingUser));

        // DO NOT login
        return response()->json(['status'  => 'success','message' => 'Your account is pending verification. Check your email.']);
    }
}
