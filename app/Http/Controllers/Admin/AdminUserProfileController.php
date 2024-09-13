<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\Transaction;

class AdminUserProfileController extends Controller
{
    public function editUser(User $user)
    {
        // Find the sponsor based on account_id
        $sponsor = User::where('account_id', $user->sponsor_id)->first();
        $sponsorName = $sponsor ? $sponsor->name : 'No Sponsor';

        return view('admin.edit-user', compact('user', 'sponsorName'));
    }

    //login as user
    public function loginAsUser(User $user)
    {
        $admin = Auth::guard('admin')->user();
        if ($admin) {
            Auth::login($user);
            // Redirect to the user's dashboard
            return redirect()->route('dashboard');
        }

        return redirect()->back()->withErrors('Unauthorized access.');
    }

    public function loginAsAgent(Agent $agent)
    {
        $admin = Auth::guard('admin')->user();
        if ($admin) {
            Auth::guard('agent')->login($agent); // Ensure the correct guard is used
            // Redirect to the agent's dashboard
            return redirect()->route('agent.dashboard'); // Ensure this route name is correct
        }

        return redirect()->back()->withErrors('Unauthorized access.');
    }

    public function updateUser(Request $request, User $user)
    {
        try {
            // Validate the form data
            $request->validate([
                'name' => 'required|string|max:50',
                'email' => 'required|string|email|max:50|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:4',
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'number' => 'required|string',
                'country' => 'string|nullable',
                'city' => 'string|nullable',
                'street_address' => 'string|nullable',
            ], [
                'name.required' => 'The name field is required.',
                'email.required' => 'The email field is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.max' => 'The email address must not exceed :max characters.',
                'email.unique' => 'The email address is already in use.',
                'password.min' => 'The password must be at least :min characters long.',
                'profile_image.image' => 'The profile image must be an image file.',
                'profile_image.mimes' => 'The profile image must be in one of the following formats: jpeg, png, jpg, gif.',
                'profile_image.max' => 'The profile image must not exceed :max kilobytes in size.',
                'number.required' => 'The phone number field is required.',
            ]);

            // Update user data
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->number = $request->input('number');
            $user->country = $request->input('country');
            $user->city = $request->input('city');
            $user->street_address = $request->input('street_address');

            // Update password if provided
            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }

            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/user_profile', $imageName);
                $user->profile_image = $imageName;
            }

            $user->save();

            return redirect()->route('admin.editUser', $user->id)->with('success', 'User profile updated successfully.');
        } catch (ValidationException $e) {
            // Redirect back with validation errors
            return redirect()->route('admin.editUser', $user->id)->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Handle other exceptions (e.g., file upload error)
            return redirect()->route('admin.editUser', $user->id)->with('error', $e->getMessage())->withInput();
        }

    }


}
