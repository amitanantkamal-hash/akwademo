<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class TokenLoginController extends Controller
{
    public function login(Request $request, $token)
    {
        // Find valid token
        $accessToken = PersonalAccessToken::findToken($token);
        
        if (!$accessToken) {
            return redirect()->route('login')->withErrors(['token' => 'Invalid or expired token']);
        }

        // Get associated user
        $user = $accessToken->tokenable;

        // Login user
        Auth::login($user);

        // Delete token after use
        $accessToken->delete();

        return redirect()->intended('/dashboard');
    }
}