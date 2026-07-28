<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$role): Response
    {
        // Ensure the user is logged in
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Check if the user's role matches any of the allowed roles
        if (!in_array(auth()->user()->role, $role)) {
            abort(404, 'Not Found');
        }
    
        return $next($request);
    }
}
