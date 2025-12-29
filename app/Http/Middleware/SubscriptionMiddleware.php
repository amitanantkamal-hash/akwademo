<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class SubscriptionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user && $user->company) {
            $company = $user->company;
            if ($company->activeSubscription) {
                return $next($request);
            }
            if ($company->pendingSubscription) {
                return redirect()->route('pending.subscription');
            }

            return redirect()->route('available.plans');
        }
        return redirect()->route('login');
    }
}