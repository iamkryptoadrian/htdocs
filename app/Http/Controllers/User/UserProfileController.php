<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{

    public function editUser()
    {
        $user = Auth::user(); // Get the authenticated user

        return view('profile.edit', compact('user'));
    }


    public function updateUserProfile(Request $request, User $user)
    {
        DB::beginTransaction(); // Start transaction
        try {
            // Validate the form data
            $request->validate([
                'first_name' => 'required|string|max:50',
                'last_name' => 'nullable|string|max:50',
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'number' => 'nullable|string|max:15',
                'date_of_birth' => 'nullable|date',
                'state' => 'nullable|string|max:100',
                'zip_code' => 'nullable|string|max:10',
                'country' => 'nullable|string|max:100',
                'city' => 'nullable|string|max:100',
                'street_address' => 'nullable|string|max:255',
                'old_password' => 'nullable|required_with:new_password,password_confirmation|string|min:6',
                'new_password' => 'nullable|string|min:6|confirmed',
            ]);
    
            // Update user data
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            $user->number = $request->input('number');
            $user->date_of_birth = $request->input('date_of_birth');
            $user->state = $request->input('state');
            $user->zip_code = $request->input('zip_code');
            $user->country = $request->input('country');
            $user->city = $request->input('city');
            $user->street_address = $request->input('street_address');
    
            // Update password if provided
            if ($request->filled('new_password')) {
                if (Hash::check($request->input('old_password'), $user->password)) {
                    $user->password = Hash::make($request->input('new_password'));
                } else {
                    return back()->with('error', 'Old password does not match.')->withInput();
                }
            }
    
            $user->save();
            DB::commit(); // Commit transaction
    
            return redirect()->route('profile.edit', $user->id)->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack(); // Roll back transaction on error
            return redirect()->route('profile.edit', $user->id)->with('error', 'An error occurred: ' . $e->getMessage())->withInput();
        }
    }


}
