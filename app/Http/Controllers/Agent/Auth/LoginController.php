<?php

namespace App\Http\Controllers\Agent\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AgentLoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('agent.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(AgentLoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('agent')->attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(RouteServiceProvider::AGENT_HOME);
        }

        // Authentication failed, add an error message
        return redirect()->route('agent.login')->with('error', 'Invalid email or password');
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('agent')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('agent.login');
    }
}

