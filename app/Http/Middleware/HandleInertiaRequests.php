<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

// Temporary middleware stub - Inertia will be installed separately
class HandleInertiaRequests
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, $next)
    {
        return $next($request);
    }
}
