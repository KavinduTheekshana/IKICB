<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $courses = Course::with('instructor')
            ->where('is_published', true)
            ->withCount('modules')
            ->latest()
            ->paginate(9);

        return view('frontend.home', compact('courses'));
    }

    public function about()
    {
        $instructors = Instructor::active()->ordered()->get();

        return view('frontend.about', compact('instructors'));
    }

    public function contact()
    {
        return view('frontend.contact');
    }
}
