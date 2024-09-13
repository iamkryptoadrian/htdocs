<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AgentProfileController extends Controller
{
    public function editAgent()
    {
        $agent = Auth::guard('agent')->user();
        return view('agent.profile.index', compact('agent'));
    }

    public function updateAgentProfile(Request $request)
    {
        $agent = Auth::guard('agent')->user();

        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:agents,email,' . $agent->id,
            'company_name' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postcode' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'old_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update agent details
        $agent->update($request->only([
            'name',
            'email',
            'company_name',
            'phone_number',
            'street',
            'city',
            'postcode',
            'country',
        ]));

        // Update password if provided
        if ($request->filled('old_password') && $request->filled('new_password')) {
            if (Hash::check($request->old_password, $agent->password)) {
                $agent->update([
                    'password' => Hash::make($request->new_password),
                ]);
            } else {
                return redirect()->back()->withErrors(['old_password' => 'Old password is incorrect']);
            }
        }

        return redirect()->route('agent.profile.edit')->with('success', 'Profile updated successfully.');
    }

    public function updateAgentPassword(Request $request)
    {
        $agent = Auth::guard('agent')->user();

        // Validate the input
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Update password if old password matches
        if (Hash::check($request->old_password, $agent->password)) {
            $agent->update([
                'password' => Hash::make($request->new_password),
            ]);

            return redirect()->route('agent.profile.edit')->with('success', 'Password updated successfully.');
        } else {
            return redirect()->back()->withErrors(['old_password' => 'Old password is incorrect']);
        }
    }
}
