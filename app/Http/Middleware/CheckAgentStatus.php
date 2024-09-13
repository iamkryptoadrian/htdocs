<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Agent;
use Illuminate\Support\Facades\Log;



class CheckAgentStatus
{
    public function handle(Request $request, Closure $next)
    {
        $agent = auth()->guard('agent')->user();
        if ($agent && $agent->account_status === 'banned') {
            auth()->guard('agent')->logout();
            return redirect()->route('agent.login')->with('error', 'Your account has been Blacklisted. Please contact support.');
        }

        return $next($request);
    }
}
