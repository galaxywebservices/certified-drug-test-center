<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminProfileController extends Controller
{
    /**
     * Show the Super Admin profile and security settings.
     */
    public function edit()
    {
        $user = auth()->user();
        return view('admin.profile.index', compact('user'));
    }

    /**
     * Update the Super Admin basic profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:50',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ]);

        return redirect()->route('admin.profile')
            ->with('success', 'Super administrator profile updated successfully.');
    }

    /**
     * Change the Super Admin account password.
     */
    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => 'required|string',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The provided current password does not match our records.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.profile')
            ->with('success', 'Your password has been changed successfully. Please keep your new credentials secure.');
    }
}
