<?php

namespace App\Http\Controllers\Agent\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class AgentPasswordResetLinkController extends Controller
{
    public function create()
    {
        return view('agent.auth.forgot-password');
    }

    public function store(Request $request)
    {
        $request->merge([
            'email' => filter_var($request->input('email'), FILTER_SANITIZE_EMAIL),
        ]);

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
        ]);

        if ($validator->fails()) {
            Log::warning('Agent password reset link request validation failed.', [
                'email' => $request->input('email'),
                'errors' => $validator->errors()->toArray(),
            ]);
            return back()->withErrors($validator)->withInput();
        }

        try {
            $status = Password::broker('agents')->sendResetLink(
                $request->only('email')
            );

            Log::info('Agent password reset link sent.', [
                'email' => $request->input('email'),
                'status' => $status,
            ]);

            return $status == Password::RESET_LINK_SENT
                ? back()->with('status', __($status))
                : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
        } catch (\Exception $e) {
            Log::error('Error sending agent password reset link.', [
                'email' => $request->input('email'),
                'error' => $e->getMessage(),
            ]);

            return back()->withErrors(['email' => 'An error occurred while sending the password reset link. Please try again later.'])
                         ->withInput($request->only('email'));
        }
    }
}
