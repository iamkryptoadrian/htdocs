<?php

namespace App\Http\Controllers\Agent\Auth;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class AgentPasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('agent.auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        try {
            $status = Password::broker('agents')->sendResetLink(
                $request->only('email')
            );

            if ($status == Password::RESET_LINK_SENT) {
              //  Log::info('Agent password reset link sent.', ['email' => $request->email, 'status' => $status]);
                return back()->with('status', __($status));
            } else {
                //Log::warning('Agent password reset link failed.', ['email' => $request->email, 'status' => $status]);
                return back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
            }
        } catch (\Exception $e) {
            //Log::error('Error sending agent password reset link.', ['email' => $request->email, 'error' => $e->getMessage()]);
            return back()->withInput($request->only('email'))
                        ->withErrors(['email' => 'An error occurred while sending the password reset link.']);
        }
    }
}
