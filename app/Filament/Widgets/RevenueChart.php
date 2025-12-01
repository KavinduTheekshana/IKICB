<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Widgets\ChartWidget;

class RevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Revenue Overview';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public ?string $filter = '30days';

    protected function getData(): array
    {
        $data = match ($this->filter) {
            '7days' => $this->getLast7DaysData(),
            '30days' => $this->getLast30DaysData(),
            '90days' => $this->getLast90DaysData(),
            '12months' => $this->getLast12MonthsData(),
            default => $this->getLast30DaysData(),
        };

        return [
            'datasets' => [
                [
                    'label' => 'Revenue (LKR)',
                    'data' => $data['amounts'],
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Transactions',
                    'data' => $data['counts'],
                    'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                    'borderColor' => 'rgb(34, 197, 94)',
                    'fill' => true,
                    'tension' => 0.4,
                    'yAxisID' => 'y1',
                ],
            ],
            'labels' => $data['labels'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFilters(): ?array
    {
        return [
            '7days' => 'Last 7 days',
            '30days' => 'Last 30 days',
            '90days' => 'Last 90 days',
            '12months' => 'Last 12 months',
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'position' => 'left',
                    'title' => [
                        'display' => true,
                        'text' => 'Revenue (LKR)',
                    ],
                ],
                'y1' => [
                    'beginAtZero' => true,
                    'position' => 'right',
                    'title' => [
                        'display' => true,
                        'text' => 'Transactions',
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

    protected function getLast7DaysData(): array
    {
        $labels = [];
        $amounts = [];
        $counts = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->startOfDay();
            $labels[] = $date->format('M d');

            $dayPayments = Payment::where('status', 'completed')
                ->whereDate('created_at', $date)
                ->get();

            $amounts[] = (float) $dayPayments->sum('amount');
            $counts[] = $dayPayments->count();
        }

        return compact('labels', 'amounts', 'counts');
    }

    protected function getLast30DaysData(): array
    {
        $labels = [];
        $amounts = [];
        $counts = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->startOfDay();
            $labels[] = $date->format('M d');

            $dayPayments = Payment::where('status', 'completed')
                ->whereDate('created_at', $date)
                ->get();

            $amounts[] = (float) $dayPayments->sum('amount');
            $counts[] = $dayPayments->count();
        }

        return compact('labels', 'amounts', 'counts');
    }

    protected function getLast90DaysData(): array
    {
        $labels = [];
        $amounts = [];
        $counts = [];

        for ($i = 12; $i >= 0; $i--) {
            $startDate = now()->subDays($i * 7)->startOfDay();
            $endDate = now()->subDays(($i - 1) * 7)->startOfDay();
            $labels[] = $startDate->format('M d');

            $weekPayments = Payment::where('status', 'completed')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

            $amounts[] = (float) $weekPayments->sum('amount');
            $counts[] = $weekPayments->count();
        }

        return compact('labels', 'amounts', 'counts');
    }

    protected function getLast12MonthsData(): array
    {
        $labels = [];
        $amounts = [];
        $counts = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i)->startOfMonth();
            $labels[] = $date->format('M Y');

            $monthPayments = Payment::where('status', 'completed')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->get();

            $amounts[] = (float) $monthPayments->sum('amount');
            $counts[] = $monthPayments->count();
        }

        return compact('labels', 'amounts', 'counts');
    }
}
