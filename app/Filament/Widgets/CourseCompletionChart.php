<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\ModuleCompletion;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class CourseCompletionChart extends ChartWidget
{
    protected static ?string $heading = 'Course Completion Rates';

    protected static ?int $sort = 7;

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        // Get top 10 courses by enrollment
        $courses = Course::withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->limit(10)
            ->get();

        $labels = [];
        $completionRates = [];
        $enrollments = [];

        foreach ($courses as $course) {
            $labels[] = $course->title;
            $enrollments[] = $course->enrollments_count;

            // Calculate completion rate
            $totalModules = $course->modules()->count();

            if ($totalModules > 0) {
                // Get students who completed all modules
                $completedStudents = DB::table('enrollments')
                    ->where('course_id', $course->id)
                    ->whereExists(function ($query) use ($course, $totalModules) {
                        $query->select(DB::raw(1))
                            ->from('module_completions')
                            ->whereColumn('module_completions.user_id', 'enrollments.user_id')
                            ->whereIn('module_completions.module_id', function ($subQuery) use ($course) {
                                $subQuery->select('id')
                                    ->from('modules')
                                    ->where('course_id', $course->id);
                            })
                            ->havingRaw('COUNT(DISTINCT module_completions.module_id) = ?', [$totalModules]);
                    })
                    ->count();

                $completionRate = $course->enrollments_count > 0
                    ? ($completedStudents / $course->enrollments_count) * 100
                    : 0;
            } else {
                $completionRate = 0;
            }

            $completionRates[] = round($completionRate, 1);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Completion Rate (%)',
                    'data' => $completionRates,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.5)',
                    'borderColor' => 'rgb(34, 197, 94)',
                    'yAxisID' => 'y',
                ],
                [
                    'label' => 'Total Enrollments',
                    'data' => $enrollments,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'yAxisID' => 'y1',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'max' => 100,
                    'position' => 'left',
                    'title' => [
                        'display' => true,
                        'text' => 'Completion Rate (%)',
                    ],
                ],
                'y1' => [
                    'beginAtZero' => true,
                    'position' => 'right',
                    'title' => [
                        'display' => true,
                        'text' => 'Total Enrollments',
                    ],
                    'grid' => [
                        'drawOnChartArea' => false,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
        ];
    }
}
