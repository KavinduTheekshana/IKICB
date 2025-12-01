<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
            ->with(['course', 'module'])
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
            ->with(['course', 'module'])
            ->latest()
            ->paginate(15);

        return view('frontend.dashboard.payments', compact('payments'));
    }
}
