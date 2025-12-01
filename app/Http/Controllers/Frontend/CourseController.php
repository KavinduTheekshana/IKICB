<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('instructor')
            ->where('is_published', true)
            ->withCount('modules')
            ->paginate(12);

        return view('frontend.courses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        $course->load(['instructor', 'modules' => function ($query) {
            $query->orderBy('order');
        }]);

        $isEnrolled = false;
        $unlockedModules = collect();

        if (auth()->check()) {
            $enrollment = auth()->user()->enrollments()
                ->where('course_id', $course->id)
                ->first();

            $isEnrolled = $enrollment !== null;

            if ($isEnrolled) {
                $unlockedModules = auth()->user()->moduleUnlocks()
                    ->whereIn('module_id', $course->modules->pluck('id'))
                    ->pluck('module_id');
            }
        }

        return view('frontend.courses.show', compact('course', 'isEnrolled', 'unlockedModules'));
    }

    public function module(Module $module)
    {
        $module->load(['course', 'materials', 'questions.category', 'theoryExams']);

        // Check if user has access
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to access course content.');
        }

        $hasAccess = auth()->user()->moduleUnlocks()
            ->where('module_id', $module->id)
            ->exists();

        if (!$hasAccess) {
            return redirect()->route('courses.show', $module->course)
                ->with('error', 'You need to purchase this module to access it.');
        }

        return view('frontend.courses.module', compact('module'));
    }
}
