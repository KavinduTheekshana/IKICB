<?php

namespace App\Filament\Resources\CourseStudentMarksResource\Pages;

use App\Filament\Resources\CourseStudentMarksResource;
use App\Models\Enrollment;
use App\Models\ModuleCompletion;
use App\Models\QuizAttempt;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;

class CourseModuleMarks extends Page
{
    use InteractsWithRecord;

    protected static string $resource = CourseStudentMarksResource::class;

    protected static string $view = 'filament.resources.course-student-marks-resource.pages.course-module-marks';

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    public function getTitle(): string
    {
        return 'Student Marks: ' . $this->record->title;
    }

    public function getModuleMarksData(): array
    {
        $course = $this->record->load(['modules' => fn ($q) => $q->orderBy('order')]);

        // All students enrolled in this course
        $enrollments = Enrollment::with('user')
            ->where('course_id', $course->id)
            ->get();

        $students = $enrollments->map->user->unique('id');

        $moduleIds = $course->modules->pluck('id');

        // Load all quiz attempts and completions for this course in one query each
        $allAttempts = QuizAttempt::whereIn('module_id', $moduleIds)
            ->whereIn('user_id', $students->pluck('id'))
            ->get()
            ->groupBy(['module_id', 'user_id']);

        $allCompletions = ModuleCompletion::whereIn('module_id', $moduleIds)
            ->whereIn('user_id', $students->pluck('id'))
            ->get()
            ->groupBy(['module_id', 'user_id']);

        $modules = [];

        foreach ($course->modules as $module) {
            $studentMarks = [];

            foreach ($students as $student) {
                $attempts = $allAttempts[$module->id][$student->id] ?? collect();
                $completion = ($allCompletions[$module->id][$student->id] ?? collect())->first();

                $bestScore = $attempts->max('score');
                $avgScore = $attempts->avg('score');
                $attemptCount = $attempts->count();

                $studentMarks[] = [
                    'id'          => $student->id,
                    'name'        => $student->name,
                    'email'       => $student->email,
                    'completed'   => (bool) $completion,
                    'attempts'    => $attemptCount,
                    'best_score'  => $bestScore !== null ? number_format($bestScore, 1) . '%' : null,
                    'avg_score'   => $avgScore !== null ? number_format($avgScore, 1) . '%' : null,
                    'completed_at' => $completion?->completed_at?->format('M d, Y'),
                ];
            }

            // Sort: completed first, then by best score desc
            usort($studentMarks, function ($a, $b) {
                if ($a['completed'] !== $b['completed']) {
                    return $b['completed'] <=> $a['completed'];
                }
                return floatval($b['best_score']) <=> floatval($a['best_score']);
            });

            $modules[] = [
                'id'          => $module->id,
                'title'       => $module->title,
                'order'       => $module->order,
                'total_enrolled' => $students->count(),
                'completed_count' => collect($studentMarks)->where('completed', true)->count(),
                'students'    => $studentMarks,
            ];
        }

        return [
            'course'   => $course,
            'modules'  => $modules,
            'total_students' => $students->count(),
        ];
    }
}
