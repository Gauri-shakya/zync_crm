<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckCompanyAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();
        $company = $user->company;

        // No company or Deactivated company → logout
        if (!$company || $company->status === 'deactive') {
            Auth::logout();
            $message = !$company ? 'Company not found.' : 'Your company account has been deactivated. Please contact support.';
            return redirect()->route('login.show')->with('error', $message);
        }

        // 🔒 TRIAL EXPIRED & NOT PAID
        if (
            !$company->is_paid &&
            $company->trial_ends_at && 
            now()->greaterThan($company->trial_ends_at)
        ) {

            // Allow ONLY upgrade & auth routes
            if (
                $request->routeIs('upgrade.index') ||
                $request->routeIs('logout') ||
                $request->routeIs('login')
            ) {
                return $next($request);
            }

            // Everything else BLOCKED
            return redirect()->route('upgrade.index');
        }

        return $next($request);
    }
}
