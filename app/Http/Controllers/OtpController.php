<?php

namespace App\Http\Controllers;

use App\Helpers\StaticHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    public function show()
    {
        if (auth()->user()->is_otp_verified):
            return redirect('home');
        endif;
        return view('auth.verify-otp');
    }

    public function verify(Request $request)
    {
        if (auth()->user()->is_otp_verified):
            return redirect('home');
        endif;
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $user = Auth::user();

        if ($user->otp == $request->otp) {
            $user->otp = null;
            $user->is_otp_verified = 1;
            $user->save();
            return response()->json(['status' => 'success', 'message' => 'OTP verified successfully'], 200);
        } else {
            return response()->json(['status' => 'fail', 'error' => 'Invalid OTP. Please try again.'], 400);
        }
        // if ($user->otp == $request->otp) {
        //     $user->is_otp_verified = 1;
        //     $user->save();
        //     return redirect()->route('home')->with('success', 'OTP verified successfully');
        // }

        // return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
    }
    public function resendOtp(Request $request)
    {
        if (auth()->user()->is_otp_verified):
            return redirect('home');
        endif;

        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $resendOTPLimit = config('settings.otp_resend_allowed_limit', 1);

        if ($user->otp_resend >= $resendOTPLimit) {
            return response()->json(['error' => 'OTP resend limit exceeded. Please contact support.'], 403);
        }

        if ($user->otp_sent_at && now()->diffInSeconds($user->otp_sent_at) < config('otp.otp_timer')) {
            return response()->json(['error' => 'Please wait before resending the OTP'], 429);
        }

        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->increment('otp_resend');
        $user->otp_sent_at = now();
        $user->save();

        // Send OTP via WhatsApp
        StaticHelper::sendWA_OTP($otp, $user->phone);

        return response()->json(['message' => 'OTP resent successfully'], 200);
    }

    public function updatePhone(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'string', 'max:255', 'unique:users,phone'],
        ]);

        $user = Auth::user();

        $changeNumberLimit = config('settings.change_number_allowed_limit', 1);

        if ($user->otp_change_number >= $changeNumberLimit) {
            return response()->json(['status' => 'fail', 'error' => 'change_limit_exceeded', 'message' => 'Phone number change limit exceeded. Please contact support.'], 403);
        }

        if (User::where('phone', $request->phone)->exists()) {
            return response()->json(['status' => 'fail', 'error' => 'number_exists', 'message' => 'WhatsApp number already in use.'], 400);
        }

        // Update phone number
        $user->phone = $request->phone;
        $user->increment('otp_change_number');
        $user->save();

        // Generate and send new OTP
        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->increment('otp_resend'); 
        $user->otp_sent_at = now();
        $user->save();

        // Send OTP via WhatsApp
        StaticHelper::sendWA_OTP($otp, $user->phone);

        return response()->json(['status' => 'success', 'message' => 'Phone number updated and OTP resent successfully.']);
    }
}
