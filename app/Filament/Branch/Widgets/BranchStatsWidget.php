<?php

namespace App\Filament\Branch\Widgets;

use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BranchStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $branchId = auth()->user()->branch_id;
        $branchName = auth()->user()->branch?->name ?? 'Branch';

        $totalStudents = User::where('role', 'student')->where('branch_id', $branchId)->count();
        $newStudentsThisMonth = User::where('role', 'student')
            ->where('branch_id', $branchId)
            ->whereMonth('created_at', now()->month)
            ->count();

        $totalEnrollments = Enrollment::whereHas('user', fn ($q) => $q->where('branch_id', $branchId))->count();
        $activeEnrollments = Enrollment::whereHas('user', fn ($q) => $q->where('branch_id', $branchId))
            ->where('status', 'active')
            ->count();

        $totalRevenue = Payment::whereHas('user', fn ($q) => $q->where('branch_id', $branchId))
            ->where('status', 'completed')
            ->sum('amount');

        $pendingPayments = Payment::whereHas('user', fn ($q) => $q->where('branch_id', $branchId))
            ->where('status', 'pending')
            ->count();

        return [
            Stat::make('Total Students', $totalStudents)
                ->description("+{$newStudentsThisMonth} this month")
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('success')
                ->icon('heroicon-o-academic-cap'),

            Stat::make('Total Enrollments', $totalEnrollments)
                ->description("{$activeEnrollments} active")
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary')
                ->icon('heroicon-o-user-group'),

            Stat::make('Total Revenue', 'LKR ' . number_format($totalRevenue, 2))
                ->description('Completed payments')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success')
                ->icon('heroicon-o-banknotes'),

            Stat::make('Pending Payments', $pendingPayments)
                ->description('Awaiting approval')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingPayments > 0 ? 'warning' : 'gray')
                ->icon('heroicon-o-credit-card'),
        ];
    }
}
