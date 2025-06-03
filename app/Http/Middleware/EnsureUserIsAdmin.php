<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            // Redirect non-admins to the regular dashboard or a 403 error page
            // Or you can abort with a 403 error
            // abort(403, 'Unauthorized action.');
            return redirect('dashboard')->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
