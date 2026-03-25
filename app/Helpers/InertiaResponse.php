<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Response;

/**
 * Temporary response helper for Inertia-like behavior
 * Returns JSON response instead of Inertia until properly installed
 */
class InertiaResponse
{
    public static function render($component, $props = [])
    {
        // Return JSON for API-like response
        return response()->json([
            'component' => $component,
            'props' => $props,
            'csrf_token' => csrf_token(),
            'auth' => [
                'user' => auth()->user(),
            ],
            'flash' => [
                'success' => session('success'),
                'error' => session('error'),
            ],
        ]);
    }
}
