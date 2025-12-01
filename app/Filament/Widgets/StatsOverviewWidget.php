<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\ModuleCompletion;
use App\Models\Payment;
use App\Models\QuizAttempt;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        // Get current month data
        $currentMonth = now()->startOfMonth();
        $lastMonth = now()->subMonth()->startOfMonth();

        // Total Revenue
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $currentMonthRevenue = Payment::where('status', 'completed')
            ->where('created_at', '>=', $currentMonth)
            ->sum('amount');
        $lastMonthRevenue = Payment::where('status', 'completed')
            ->where('created_at', '>=', $lastMonth)
            ->where('created_at', '<', $currentMonth)
            ->sum('amount');
        $revenueChange = $lastMonthRevenue > 0
            ? (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100
            : 0;

        // Total Students
        $totalStudents = User::where('role', 'student')->count();
        $currentMonthStudents = User::where('role', 'student')
            ->where('created_at', '>=', $currentMonth)
            ->count();
        $lastMonthStudents = User::where('role', 'student')
            ->where('created_at', '>=', $lastMonth)
            ->where('created_at', '<', $currentMonth)
            ->count();
        $studentsChange = $lastMonthStudents > 0
            ? (($currentMonthStudents - $lastMonthStudents) / $lastMonthStudents) * 100
            : 0;

        // Total Enrollments
        $totalEnrollments = Enrollment::count();
        $currentMonthEnrollments = Enrollment::where('created_at', '>=', $currentMonth)->count();
        $lastMonthEnrollments = Enrollment::where('created_at', '>=', $lastMonth)
            ->where('created_at', '<', $currentMonth)
            ->count();
        $enrollmentsChange = $lastMonthEnrollments > 0
            ? (($currentMonthEnrollments - $lastMonthEnrollments) / $lastMonthEnrollments) * 100
            : 0;

        // Active Courses
        $activeCourses = Course::where('is_published', true)->count();
        $totalCourses = Course::count();

        // Module Completions
        $totalCompletions = ModuleCompletion::count();
        $currentMonthCompletions = ModuleCompletion::where('created_at', '>=', $currentMonth)->count();
        $lastMonthCompletions = ModuleCompletion::where('created_at', '>=', $lastMonth)
            ->where('created_at', '<', $currentMonth)
            ->count();
        $completionsChange = $lastMonthCompletions > 0
            ? (($currentMonthCompletions - $lastMonthCompletions) / $lastMonthCompletions) * 100
            : 0;

        // Quiz Attempts
        $totalQuizAttempts = QuizAttempt::count();
        $averageQuizScore = QuizAttempt::avg('score');

        return [
            Stat::make('Total Revenue', 'LKR ' . number_format($totalRevenue, 2))
                ->description($revenueChange >= 0 ? '+' . number_format($revenueChange, 1) . '% from last month' : number_format($revenueChange, 1) . '% from last month')
                ->descriptionIcon($revenueChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($revenueChange >= 0 ? 'success' : 'danger')
                ->chart($this->getMonthlyRevenueChart()),

            Stat::make('Total Students', number_format($totalStudents))
                ->description($studentsChange >= 0 ? '+' . number_format($studentsChange, 1) . '% from last month' : number_format($studentsChange, 1) . '% from last month')
                ->descriptionIcon($studentsChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($studentsChange >= 0 ? 'success' : 'danger')
                ->chart($this->getMonthlyStudentsChart()),

            Stat::make('Total Enrollments', number_format($totalEnrollments))
                ->description($enrollmentsChange >= 0 ? '+' . number_format($enrollmentsChange, 1) . '% from last month' : number_format($enrollmentsChange, 1) . '% from last month')
                ->descriptionIcon($enrollmentsChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($enrollmentsChange >= 0 ? 'success' : 'danger')
                ->chart($this->getMonthlyEnrollmentsChart()),

            Stat::make('Active Courses', $activeCourses . ' / ' . $totalCourses)
                ->description('Published courses')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('info'),

            Stat::make('Module Completions', number_format($totalCompletions))
                ->description($completionsChange >= 0 ? '+' . number_format($completionsChange, 1) . '% from last month' : number_format($completionsChange, 1) . '% from last month')
                ->descriptionIcon($completionsChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($completionsChange >= 0 ? 'success' : 'danger')
                ->chart($this->getMonthlyCompletionsChart()),

            Stat::make('Average Quiz Score', number_format($averageQuizScore, 1) . '%')
                ->description($totalQuizAttempts . ' total attempts')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color($averageQuizScore >= 70 ? 'success' : ($averageQuizScore >= 50 ? 'warning' : 'danger')),
        ];
    }

    protected function getMonthlyRevenueChart(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subMonths($i)->startOfMonth();
            $amount = Payment::where('status', 'completed')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('amount');
            $data[] = (float) $amount;
        }
        return $data;
    }

    protected function getMonthlyStudentsChart(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subMonths($i)->startOfMonth();
            $count = User::where('role', 'student')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $data[] = $count;
        }
        return $data;
    }

    protected function getMonthlyEnrollmentsChart(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subMonths($i)->startOfMonth();
            $count = Enrollment::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $data[] = $count;
        }
        return $data;
    }

    protected function getMonthlyCompletionsChart(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subMonths($i)->startOfMonth();
            $count = ModuleCompletion::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $data[] = $count;
        }
        return $data;
    }
}
