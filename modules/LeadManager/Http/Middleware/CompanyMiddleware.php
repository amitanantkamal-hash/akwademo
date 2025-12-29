<?php

namespace Modules\LeadManager\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CompanyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated and has a company
        if (!auth()->check() || !auth()->user()->company_id) {
            return redirect('/')->with('error', 'You must be associated with a company to access this resource.');
        }

        return $next($request);
    }
}