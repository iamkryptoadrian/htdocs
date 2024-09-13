<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginType = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'id';
        $credentials = [$loginType => $request->input('login'), 'password' => $request->password];

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Check if a redirect URL was provided and it is valid; otherwise, redirect to the default home route
            $redirectUrl = $request->input('redirect');
            if (!empty($redirectUrl) && $this->isValidRedirectUrl($redirectUrl)) {
                return redirect($redirectUrl);
            }

            return redirect(RouteServiceProvider::HOME);
        }

        throw ValidationException::withMessages([
            'login' => [__('auth.failed')],
        ]);
    }

    protected function isValidRedirectUrl($url)
    {
        // Parse the URL to get its path
        $path = parse_url($url, PHP_URL_PATH);

        // Define a list of valid paths
        $validPaths = [
            '/booking-step2',
            // Add other paths here as needed
        ];

        // Check if the parsed path is in the list of valid paths
        return in_array($path, $validPaths);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
