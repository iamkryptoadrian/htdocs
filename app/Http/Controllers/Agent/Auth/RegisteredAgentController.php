<?php

namespace App\Http\Controllers\Agent\Auth;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Exception;

class RegisteredAgentController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('agent.auth.register');
    }

    public function register(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:agents',
            'password' => 'required|string|min:8|confirmed',
            'company_name' => 'nullable|string|max:255',
            'phone_number' => 'required|digits_between:10,15',
            'street' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postcode' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:255',
        ]);

        try {
            // Create the full name from first and last names
            $fullName = $validatedData['first_name'] . ' ' . $validatedData['last_name'];

            // Create a new agent instance
            $agent = Agent::create([
                'name' => $fullName,
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']), // Hash the password
                'company_name' => $validatedData['company_name'] ?? null,
                'phone_number' => $validatedData['phone_number'],
                'street' => $validatedData['street'] ?? null,
                'city' => $validatedData['city'] ?? null,
                'postcode' => $validatedData['postcode'] ?? null,
                'country' => $validatedData['country'] ?? null,
                'account_status' => 'active', // Default account status
            ]);

            // Log in the new agent
            Auth::login($agent);

            return redirect('/agent/dashboard')->with('status', 'Registration successful!');

        } catch (Exception $e) {
            // Handle any exceptions
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

}
