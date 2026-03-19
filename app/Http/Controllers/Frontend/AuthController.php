<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetOtpMail;
use App\Models\Branch;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('frontend.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $branches = Branch::active()->orderBy('location')->get();
        $courses = Course::where('is_published', true)->orderBy('title')->get();

        return view('frontend.auth.register', compact('branches', 'courses'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'course_id' => ['required', 'exists:courses,id'],
            'branch_id' => ['required', 'exists:branches,id'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
            'course_id' => $validated['course_id'],
            'branch_id' => $validated['branch_id'],
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Account created successfully! Welcome to IKICB LMS.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been logged out successfully.');
    }

    // ─── Forgot Password ────────────────────────────────────────────────────────

    public function showForgotPassword()
    {
        return view('frontend.auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No account found with this email address.'])->onlyInput('email');
        }

        // Delete any existing OTP for this email
        DB::table('password_reset_otps')->where('email', $request->email)->delete();

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        DB::table('password_reset_otps')->insert([
            'email' => $request->email,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Mail::to($request->email)->send(new PasswordResetOtpMail($otp));

        return redirect()->route('password.otp', ['email' => $request->email])
            ->with('success', 'OTP sent to your email. Please check your inbox.');
    }

    public function showVerifyOtp(Request $request)
    {
        $email = $request->query('email');

        if (!$email) {
            return redirect()->route('password.forgot');
        }

        return view('frontend.auth.verify-otp', compact('email'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required', 'digits:6'],
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

        // Store verified state in session
        $request->session()->put('otp_verified_email', $request->email);

        return redirect()->route('password.reset.form');
    }

    public function showResetPassword(Request $request)
    {
        if (!$request->session()->has('otp_verified_email')) {
            return redirect()->route('password.forgot');
        }

        return view('frontend.auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        if (!$request->session()->has('otp_verified_email')) {
            return redirect()->route('password.forgot');
        }

        $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $email = $request->session()->pull('otp_verified_email');

        User::where('email', $email)->update([
            'password' => Hash::make($request->password),
        ]);

        DB::table('password_reset_otps')->where('email', $email)->delete();

        return redirect()->route('login')->with('success', 'Password reset successfully. Please sign in with your new password.');
    }
}
