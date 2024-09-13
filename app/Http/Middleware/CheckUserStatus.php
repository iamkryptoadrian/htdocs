<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;



class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if ($user && $user->status === 0) {
            // User is banned, prevent login and redirect with an error message
            auth()->logout(); // Logout the user if they were already logged in
            return redirect()->route('login')->with('error', 'Your account has been restricted. Please contact support.');
        }

        return $next($request);
    }
}
