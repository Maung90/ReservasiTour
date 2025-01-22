<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAuthenticated
{
    public function handle(Request $request, Closure $next, ...$roles)
    {

        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Login terlebih dahulu!');
        }

        if (!empty($roles) && !in_array(Auth::user()->role_id, $roles)) {
            return redirect('/not-found');
        }

        return $next($request);
    }
}
