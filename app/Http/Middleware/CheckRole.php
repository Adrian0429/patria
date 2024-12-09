<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Get the role of the authenticated user
        $userRole = Auth::user()->role;

        // Check if the user's role is in the allowed roles
        if (!in_array($userRole, $roles)) {
            // If the role is not allowed, redirect to home with an error
            return redirect()->route('home')->with('error', 'You do not have access to this page.');
        }

        // Continue if the user's role is in the allowed roles
        return $next($request);
    }
}
