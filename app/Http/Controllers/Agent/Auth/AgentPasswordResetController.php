<?php

namespace App\Http\Controllers\Agent\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AgentPasswordResetController extends Controller
{
    public function create(Request $request, $token)
    {
        return view('agent.auth.reset-password')->with([
            'token' => $token,
            'email' => $request->query('email')
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::broker('agents')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($agent, $password) {
                $agent->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                Log::info('Agent password reset successfully.', ['email' => $agent->email]);
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('agent.login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
