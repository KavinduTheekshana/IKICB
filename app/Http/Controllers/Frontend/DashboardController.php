<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $enrollments = $user->enrollments()
            ->with(['course.modules'])
            ->latest()
            ->get();

        $unlockedModules = $user->moduleUnlocks()
            ->with('module.course')
            ->latest()
            ->get();

        $payments = $user->payments()
            ->with(['course', 'module.course'])
            ->latest()
            ->take(10)
            ->get();

        return view('frontend.dashboard.index', compact('enrollments', 'unlockedModules', 'payments'));
    }

    public function myCourses()
    {
        $enrollments = auth()->user()->enrollments()
            ->with(['course.modules', 'course.instructor'])
            ->latest()
            ->get();

        return view('frontend.dashboard.my-courses', compact('enrollments'));
    }

    public function payments()
    {
        $payments = auth()->user()->payments()
            ->with(['course', 'module.course'])
            ->latest()
            ->paginate(15);

        return view('frontend.dashboard.payments', compact('payments'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('frontend.dashboard.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user->update($validated);

        return redirect()->route('dashboard.profile')
            ->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        // Verify current password
        if (!\Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update password
        $user->update([
            'password' => \Hash::make($validated['password']),
        ]);

        return redirect()->route('dashboard.profile')
            ->with('success', 'Password updated successfully!');
    }
}
