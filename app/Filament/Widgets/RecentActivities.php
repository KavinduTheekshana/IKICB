<?php

namespace App\Filament\Widgets;

use App\Models\Enrollment;
use App\Models\ModuleCompletion;
use App\Models\Payment;
use App\Models\QuizAttempt;
use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentActivities extends BaseWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Recent Activities')
            ->query(
                // Union query to get recent activities from multiple tables
                Payment::query()
                    ->where('status', 'completed')
                    ->latest()
                    ->limit(50)
            )
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Time')
                    ->dateTime('M d, Y h:i A')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('activity_type')
                    ->label('Activity')
                    ->getStateUsing(fn ($record) => $this->getActivityType($record))
                    ->badge()
                    ->color(fn ($record): string => $this->getActivityColor($record)),
                Tables\Columns\TextColumn::make('details')
                    ->label('Details')
                    ->getStateUsing(fn ($record) => $this->getActivityDetails($record))
                    ->wrap(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->money('LKR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Payment Method')
                    ->badge()
                    ->color('info'),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50]);
    }

    protected function getActivityType($record): string
    {
        if ($record instanceof Payment) {
            return 'Payment';
        } elseif ($record instanceof Enrollment) {
            return 'Enrollment';
        } elseif ($record instanceof ModuleCompletion) {
            return 'Module Completed';
        } elseif ($record instanceof QuizAttempt) {
            return 'Quiz Attempt';
        } elseif ($record instanceof User) {
            return 'New Student';
        }
        return 'Unknown';
    }

    protected function getActivityColor($record): string
    {
        if ($record instanceof Payment) {
            return 'success';
        } elseif ($record instanceof Enrollment) {
            return 'info';
        } elseif ($record instanceof ModuleCompletion) {
            return 'primary';
        } elseif ($record instanceof QuizAttempt) {
            return 'warning';
        } elseif ($record instanceof User) {
            return 'purple';
        }
        return 'gray';
    }

    protected function getActivityDetails($record): string
    {
        if ($record instanceof Payment) {
            $course = $record->course ? $record->course->title : 'Unknown Course';
            $module = $record->module ? ' - ' . $record->module->title : '';
            return "Paid for {$course}{$module}";
        }
        return '';
    }
}
