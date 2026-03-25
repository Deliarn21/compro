<?php

namespace App\Http\Middleware;

// Temporary Inertia stub for local development
// This will be replaced with the actual Inertia package later

class TempInertia
{
    public static function render($component, $props = [])
    {
        // Return a simple response with component data as JSON
        return response()->json([
            'component' => $component,
            'props' => $props,
            'url' => request()->url(),
        ]);
    }
}

namespace Inertia;

class Middleware
{
    protected $rootView = 'app';

    public function version($request)
    {
        return null;
    }

    public function share($request)
    {
        return [
            'auth' => ['user' => $request->user()],
            'flash' => [
                'success' => session('success'),
                'error' => session('error'),
            ],
        ];
    }
}
