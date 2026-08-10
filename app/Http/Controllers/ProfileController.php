<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    // Show the user profile
    public function viewProfile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    // Show the edit profile form
    public function editProfile()
    {
        $user = Auth::user();
        return view('admin.profile-edit', compact('user'));
    }

    // Update the user profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'company_name' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|required_with:new_password|current_password',
            'new_password' => 'nullable|confirmed|min:8',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update Company Name and Logo if provided and user has a company
        if ($user->company) {
            $companyData = [];
            if ($request->filled('company_name')) {
                $companyData['name'] = $request->company_name;
            }
            if ($request->hasFile('logo')) {
                $companyData['logo'] = $request->file('logo')->store('logos', 'public');
            }
            if (!empty($companyData)) {
                $user->company->update($companyData);
            }
        }

        // Update Password
        if ($request->filled('new_password')) {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
        }

        return redirect()->route('profile.view')->with('success', 'Profile updated successfully!');
    }
}
