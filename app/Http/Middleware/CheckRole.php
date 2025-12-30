<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     * Usage in routes: ->middleware(['auth','role:admin|attendant'])
     */
    public function handle(Request $request, Closure $next, string $roles)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $allowed = explode('|', $roles);

        if (! in_array($user->role, $allowed, true)) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
