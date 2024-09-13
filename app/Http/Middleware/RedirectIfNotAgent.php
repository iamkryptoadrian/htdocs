<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAgent
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('agent')->check()) {
            return redirect()->route('agent.login');
        }

        return $next($request);
    }
}
