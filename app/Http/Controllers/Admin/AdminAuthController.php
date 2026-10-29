<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->is_super_admin) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            if ($user->is_super_admin) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            }

            Auth::logout();
            return back()->withErrors(['email' => 'Access denied. Super administrator permissions required.']);
        }

        return back()->withErrors(['email' => 'Invalid email or password.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'You have been logged out.');
    }

    /**
     * Show Forgot Password request form.
     */
    public function showForgotPassword()
    {
        return view('admin.auth.forgot-password');
    }

    /**
     * Generate password reset token.
     */
    public function sendResetLink(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $admin = User::where('email', strtolower(trim($validated['email'])))
            ->where('is_super_admin', true)
            ->first();

        if (!$admin) {
            return back()->withErrors(['email' => 'No authorized super administrator account found with that email address.']);
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $admin->email],
            [
                'token' => $token,
                'created_at' => now(),
            ]
        );

        $resetUrl = route('admin.password.reset', ['token' => $token, 'email' => $admin->email]);

        return back()->with('status', 'Password reset instructions generated.')
                     ->with('reset_url', $resetUrl);
    }

    /**
     * Show Reset Password form.
     */
    public function showResetPassword(Request $request, string $token)
    {
        $email = $request->query('email');
        return view('admin.auth.reset-password', compact('token', 'email'));
    }

    /**
     * Reset the Super Admin password.
     */
    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $validated['email'])
            ->first();

        if (!$record || !hash_equals($record->token, $validated['token'])) {
            return back()->withErrors(['email' => 'This password reset link is invalid or has expired. Please request a new link.']);
        }

        $admin = User::where('email', $validated['email'])
            ->where('is_super_admin', true)
            ->first();

        if (!$admin) {
            return back()->withErrors(['email' => 'Admin account not found.']);
        }

        $admin->update([
            'password' => Hash::make($validated['password']),
        ]);

        DB::table('password_reset_tokens')->where('email', $validated['email'])->delete();

        return redirect()->route('admin.login')
            ->with('status', 'Your super administrator password has been reset successfully. Please sign in with your new password.')
            ->with('success', 'Your super administrator password has been reset successfully. Please sign in with your new password.');
    }
}
