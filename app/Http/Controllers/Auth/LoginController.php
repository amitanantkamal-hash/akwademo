<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first(); 

        // Check if user exists
        if (!$user) {
            return response()->json([
                'status' => false,
                'errMsg' => __('The provided credentials are incorrect.')
            ]);
        }

        // Check if user is active
        if (!$user->is_active) {
            return response()->json([
                'status' => false,
                'errMsg' => __('Your account has been deactivated. Please contact your administrator.')
            ]);
        }

        // Check password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'errMsg' => __('The provided credentials are incorrect.')
            ]);
        }

        // If admin, don't allow login
        if ($user->hasRole('admin')) {
            return response()->json([
                'status' => false,
                'errMsg' => __('Admin user cannot login.')
            ]);
        }

        // Update last login timestamp
        try {
            $user->update([
                'last_logged_in_on' => now(),
            ]);
            
            Log::info('User logged in', [
                'user_id' => $user->id,
                'email' => $user->email,
                'login_time' => now()
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update last login time', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }

        // If in the request we have expotoken, try to set it on the user record
        if ($request->has('expotoken') && $request->expotoken != '') {
            try {
                $user->expotoken = $request->expotoken;
                $user->save();
            } catch (\Exception $e) {
                Log::error('Failed to update expotoken', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        // Create authentication token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Set company session if user has a company
        if ($user->company) {
            Session::put('company_id', $user->company->id);
            
            // Set company logo if available
            if ($user->company->logo) {
                Session::put('app_logo', asset($user->company->logo));
            } else {
                Session::put('app_logo', asset('custom/imgs/icono-dark.png'));
            }
        } else {
            Session::put('app_logo', asset('custom/imgs/icono-dark.png'));
        }

        // Set user session data
        Session::put('user_id', $user->id);
        Session::put('user_name', $user->name);
        Session::put('user_email', $user->email);

        return response()->json([
            'status' => true,
            'token' => $token,
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'app_logo' => Session::get('app_logo'),
            'company_id' => $user->company_id,
            'last_login' => $user->last_logged_in_on ? $user->last_logged_in_on->format('M j, Y g:i A') : null,
            'is_active' => $user->is_active,
        ]);
    }

    /**
     * Logout user and update last activity
     */
    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            
            if ($user) {
                // Log logout activity
                Log::info('User logged out', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'logout_time' => now()
                ]);
                
                // Revoke all tokens
                $user->tokens()->delete();
            }

            // Clear session data
            Session::flush();

            return response()->json([
                'status' => true,
                'message' => __('Successfully logged out.')
            ]);

        } catch (\Exception $e) {
            Log::error('Logout error', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => false,
                'message' => __('Error during logout.')
            ]);
        }
    }

    /**
     * Check if user session is still valid
     */
    public function checkAuth(Request $request)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => __('Not authenticated.')
                ]);
            }

            // Check if user is still active
            if (!$user->is_active) {
                $request->user()->tokens()->delete();
                Session::flush();
                
                return response()->json([
                    'status' => false,
                    'message' => __('Your account has been deactivated.')
                ]);
            }

            return response()->json([
                'status' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'is_active' => $user->is_active,
                    'last_login' => $user->last_logged_in_on ? $user->last_logged_in_on->format('M j, Y g:i A') : null,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('Authentication check failed.')
            ]);
        }
    }

    /**
     * Get user login activity
     */
    public function loginActivity(Request $request)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => __('Not authenticated.')
                ]);
            }

            $activity = [
                'current_login' => $user->last_logged_in_on ? $user->last_logged_in_on->format('M j, Y g:i A') : 'Never',
                'account_created' => $user->created_at->format('M j, Y'),
                'is_active' => $user->is_active,
                'status' => $user->is_active ? 'Active' : 'Inactive',
            ];

            return response()->json([
                'status' => true,
                'activity' => $activity
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('Failed to fetch login activity.')
            ]);
        }
    }
}