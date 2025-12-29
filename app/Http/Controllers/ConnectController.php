<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

class ConnectController extends Controller
{
    public function __construct()
    {
        $this->middleware('throttle:20,1'); // 10 requests per minute
    }
    public function handleConnect(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'api_key' => 'required|string',
        ]);

        // Verify API key
        if ($validated['api_key'] !== env('CONNECT_API_KEY')) {
            return response()->json(
                [
                    'message' => 'Invalid API key',
                ],
                401,
            );
        }

        // Find user by email
        $user = User::where('email', $validated['email'])->first();

        if ($user) {
            // User exists - create one-time token
            $token = $user->createToken('ci-login-token', ['*'], now()->addMinutes(5))->plainTextToken;

            return response()->json([
                'status' => 'login',
                'redirect_url' => route('login.via.token', ['token' => $token]),
            ]);
        }

        // User doesn't exist - redirect to registration
        return response()->json(
            [
                'status' => 'register',
                'redirect_url' =>
                    url('/register') .
                    '?' .
                    http_build_query([
                        'email' => $validated['email'],
                        'name' => $validated['name'],
                    ]),
            ],
            404,
        );
    }
}
