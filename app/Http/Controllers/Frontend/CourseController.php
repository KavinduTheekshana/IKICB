<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
use App\Models\ModuleCompletion;
use App\Models\QuizAttempt;
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
        // Check if course is published
        if (!$course->is_published) {
            abort(404, 'This course is not available.');
        }

        $course->load(['instructor', 'modules' => function ($query) {
            $query->orderBy('order');
        }]);

        $isEnrolled = false;
        $unlockedModules = collect();
        $completedModules = collect();

        if (auth()->check()) {
            $enrollment = auth()->user()->enrollments()
                ->where('course_id', $course->id)
                ->first();

            $isEnrolled = $enrollment !== null;

            // Load unlocked modules regardless of enrollment status
            // This supports module-wise purchases where users unlock individual modules
            $unlockedModules = auth()->user()->moduleUnlocks()
                ->whereIn('module_id', $course->modules->pluck('id'))
                ->pluck('module_id');

            $completedModules = auth()->user()->moduleCompletions()
                ->whereIn('module_id', $course->modules->pluck('id'))
                ->pluck('module_id');
        }

        return view('frontend.courses.show', compact('course', 'isEnrolled', 'unlockedModules', 'completedModules'));
    }

    public function module(Module $module)
    {
        // Check if module exists and belongs to a published course
        if (!$module || !$module->course) {
            abort(404, 'Module not found.');
        }

        if (!$module->course->is_published) {
            abort(404, 'This course is not available.');
        }

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

        // Get MCQ questions for this module
        $mcqQuestions = $module->questions()
            ->where('type', 'mcq')
            ->with('category')
            ->get();

        // Get user's quiz attempts
        $quizAttempts = auth()->user()->quizAttempts()
            ->where('module_id', $module->id)
            ->latest()
            ->get();

        // Check if module is completed
        $isCompleted = auth()->user()->hasCompletedModule($module->id);

        return view('frontend.courses.module', compact('module', 'mcqQuestions', 'quizAttempts', 'isCompleted'));
    }

    public function submitQuiz(Request $request, Module $module)
    {
        // Check authentication
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to submit quiz.');
        }

        // Check if user has access to this module
        $hasAccess = auth()->user()->moduleUnlocks()
            ->where('module_id', $module->id)
            ->exists();

        if (!$hasAccess) {
            abort(403, 'You do not have access to this module.');
        }

        $validated = $request->validate([
            'answers' => 'required|array',
        ]);

        // Get MCQ questions for this module
        $questions = $module->questions()
            ->where('type', 'mcq')
            ->get();

        if ($questions->isEmpty()) {
            return redirect()->route('courses.module', $module)
                ->with('error', 'No quiz questions available for this module.');
        }

        $totalQuestions = $questions->count();
        $correctAnswers = 0;
        $results = [];

        foreach ($questions as $question) {
            $userAnswerIndex = $validated['answers'][$question->id] ?? null;

            // Get the actual option value from the index
            $userAnswerValue = null;
            if ($userAnswerIndex !== null && isset($question->mcq_options[$userAnswerIndex])) {
                $option = $question->mcq_options[$userAnswerIndex];
                $userAnswerValue = is_array($option) ? ($option['option'] ?? $option[0] ?? null) : $option;
            }

            $isCorrect = $userAnswerValue == $question->correct_answer;

            if ($isCorrect) {
                $correctAnswers++;
            }

            $results[$question->id] = [
                'user_answer' => $userAnswerValue,
                'user_answer_index' => $userAnswerIndex,
                'correct_answer' => $question->correct_answer,
                'is_correct' => $isCorrect,
            ];
        }

        $score = ($correctAnswers / $totalQuestions) * 100;

        // Save quiz attempt
        QuizAttempt::create([
            'user_id' => auth()->id(),
            'module_id' => $module->id,
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'score' => $score,
            'answers' => $results,
            'completed_at' => now(),
        ]);

        return redirect()->route('courses.module', $module)
            ->with('quiz_results', [
                'total' => $totalQuestions,
                'correct' => $correctAnswers,
                'score' => $score,
                'results' => $results,
            ]);
    }

    public function completeModule(Module $module)
    {
        // Check if user has access
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to mark module as completed.');
        }

        // Check if module exists
        if (!$module) {
            abort(404, 'Module not found.');
        }

        $hasAccess = auth()->user()->moduleUnlocks()
            ->where('module_id', $module->id)
            ->exists();

        if (!$hasAccess) {
            abort(403, 'You do not have access to this module.');
        }

        try {
            // Mark module as completed
            ModuleCompletion::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'module_id' => $module->id,
                ],
                [
                    'completed_at' => now(),
                ]
            );

            return redirect()->route('courses.module', $module)
                ->with('success', 'Module marked as completed!');
        } catch (\Exception $e) {
            return redirect()->route('courses.module', $module)
                ->with('error', 'An error occurred while marking the module as completed. Please try again.');
        }
    }
}
