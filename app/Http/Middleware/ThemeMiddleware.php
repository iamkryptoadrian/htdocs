<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ThemeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $theme = session('theme', config('app.default_theme'));
        view()->share('theme', $theme);
        return $next($request);
    }

}
