<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Admin;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;


class AdminProfileController extends Controller
{
    public function profile()
    {
        $admin = Auth::guard('admin')->user();

        return view('admin.profile.profile', compact('admin'));
    }
    public function updateProfile(Request $request)
    {
        $admin = Auth::guard('admin')->user();
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);
    
        // Check if the new email is unique except for the current admin
        if ($request->input('email') !== $admin->email) {
            $existingAdmin = Admin::where('email', $request->input('email'))->first();
    
            if ($existingAdmin) {
                return redirect()->route('admin.adminprofile')->with('error', 'The email address is already in use.');
            }
        }
    
        $admin->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);
    
        return redirect()->route('admin.adminprofile')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $admin = Auth::guard('admin')->user();
    
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:4',
            'new_password_confirmation' => 'required|string|min:4',
        ]);
    
        // Check if the old password matches the one in the database
        if (!Hash::check($request->input('old_password'), $admin->password)) {
            return redirect()->route('admin.adminprofile')->with('error', 'The old password is incorrect.');
        }
    
        // Check if the new password and its confirmation match
        if ($request->input('new_password') !== $request->input('new_password_confirmation')) {
            return redirect()->route('admin.adminprofile')->with('error', 'The new passwords does not match.');
        }
    
        // Update the password
        $admin->update([
            'password' => Hash::make($request->input('new_password')),
        ]);
    
        return redirect()->route('admin.adminprofile')->with('success', 'Password changed successfully.');
    }
    
}