<?php

namespace App\Http\Middleware;

use Closure;

class LastSeen {
    public function handle($request, Closure $next) {
        if (auth()->check()) {
            if (! session()->has('last_seen_update') ||
                now()->diffInMinutes(session('last_seen_update')) >= 1) {

                auth()->user()->update([
                    'last_seen' => now()
                ]);

                session(['last_seen_update' => now()]);
            }
        }

        return $next($request);
    }
}
