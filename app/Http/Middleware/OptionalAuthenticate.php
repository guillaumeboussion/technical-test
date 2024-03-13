<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OptionalAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (is_string($request->bearerToken())) {
            $user = Auth::guard('sanctum')->user();

            if (! $user instanceof User) {
                abort(401, 'Unauthenticated');
            }

            Auth::setUser($user);
        }

        return $next($request);
    }
}
