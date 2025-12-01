<?php

namespace App\Filament\Widgets;

use App\Models\Enrollment;
use App\Models\User;
use Filament\Widgets\ChartWidget;

class EnrollmentChart extends ChartWidget
{
    protected static ?string $heading = 'Student Growth & Enrollments';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public ?string $filter = '12months';

    protected function getData(): array
    {
        $data = match ($this->filter) {
            '30days' => $this->getLast30DaysData(),
            '12months' => $this->getLast12MonthsData(),
            default => $this->getLast12MonthsData(),
        };

        return [
            'datasets' => [
                [
                    'label' => 'New Students',
                    'data' => $data['students'],
                    'backgroundColor' => 'rgba(139, 92, 246, 0.5)',
                    'borderColor' => 'rgb(139, 92, 246)',
                ],
                [
                    'label' => 'New Enrollments',
                    'data' => $data['enrollments'],
                    'backgroundColor' => 'rgba(234, 88, 12, 0.5)',
                    'borderColor' => 'rgb(234, 88, 12)',
                ],
            ],
            'labels' => $data['labels'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getFilters(): ?array
    {
        return [
            '30days' => 'Last 30 days',
            '12months' => 'Last 12 months',
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
        ];
    }

    protected function getLast30DaysData(): array
    {
        $labels = [];
        $students = [];
        $enrollments = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->startOfDay();
            $labels[] = $date->format('M d');

            $students[] = User::where('role', 'student')
                ->whereDate('created_at', $date)
                ->count();

            $enrollments[] = Enrollment::whereDate('created_at', $date)->count();
        }

        return compact('labels', 'students', 'enrollments');
    }

    protected function getLast12MonthsData(): array
    {
        $labels = [];
        $students = [];
        $enrollments = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i)->startOfMonth();
            $labels[] = $date->format('M Y');

            $students[] = User::where('role', 'student')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $enrollments[] = Enrollment::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        return compact('labels', 'students', 'enrollments');
    }
}
