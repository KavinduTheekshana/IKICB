<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetOtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class FilamentAuthController extends Controller
{
    /** Allowed roles per panel */
    private array $panelRoles = [
        'admin'  => ['admin'],
        'branch' => ['branch_admin'],
    ];

    private function loginRoute(string $panel): string
    {
        return route("filament.{$panel}.auth.login");
    }

    private function allowedRoles(string $panel): array
    {
        return $this->panelRoles[$panel] ?? [];
    }

    // ── Step 1: Show email form ─────────────────────────────────────────────

    public function showForgotPassword(string $panel)
    {
        return view('filament.auth.forgot-password', compact('panel'));
    }

    public function sendOtp(Request $request, string $panel)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)
            ->whereIn('role', $this->allowedRoles($panel))
            ->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No account found with this email address.'])->onlyInput('email');
        }

        DB::table('password_reset_otps')->where('email', $request->email)->delete();

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        DB::table('password_reset_otps')->insert([
            'email'      => $request->email,
            'otp'        => $otp,
            'expires_at' => now()->addMinutes(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Mail::to($request->email)->send(new PasswordResetOtpMail($otp));

        return redirect()->route("filament.{$panel}.auth.verify-otp", ['email' => $request->email])
            ->with('success', 'OTP sent to your email. Please check your inbox.');
    }

    // ── Step 2: Verify OTP ──────────────────────────────────────────────────

    public function showVerifyOtp(Request $request, string $panel)
    {
        $email = $request->query('email');

        if (!$email) {
            return redirect()->route("filament.{$panel}.auth.forgot-password");
        }

        return view('filament.auth.verify-otp', compact('panel', 'email'));
    }

    public function verifyOtp(Request $request, string $panel)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'otp'   => ['required', 'digits:6'],
        ]);

        $record = DB::table('password_reset_otps')
            ->where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$record) {
            return back()->withErrors(['otp' => 'Invalid OTP. Please try again.'])->withInput();
        }

        if (now()->isAfter($record->expires_at)) {
            DB::table('password_reset_otps')->where('email', $request->email)->delete();
            return back()->withErrors(['otp' => 'OTP has expired. Please request a new one.'])->withInput();
        }

        $request->session()->put("otp_verified_email_{$panel}", $request->email);

        return redirect()->route("filament.{$panel}.auth.reset-password");
    }

    // ── Step 3: Reset Password ──────────────────────────────────────────────

    public function showResetPassword(Request $request, string $panel)
    {
        if (!$request->session()->has("otp_verified_email_{$panel}")) {
            return redirect()->route("filament.{$panel}.auth.forgot-password");
        }

        return view('filament.auth.reset-password', compact('panel'));
    }

    public function resetPassword(Request $request, string $panel)
    {
        if (!$request->session()->has("otp_verified_email_{$panel}")) {
            return redirect()->route("filament.{$panel}.auth.forgot-password");
        }

        $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $email = $request->session()->pull("otp_verified_email_{$panel}");

        User::where('email', $email)->update([
            'password' => Hash::make($request->password),
        ]);

        DB::table('password_reset_otps')->where('email', $email)->delete();

        return redirect($this->loginRoute($panel))
            ->with('success', 'Password reset successfully. Please sign in with your new password.');
    }
}
