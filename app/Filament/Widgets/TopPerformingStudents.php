<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class TopPerformingStudents extends BaseWidget
{
    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Top Performing Students')
            ->query(
                User::query()
                    ->where('role', 'student')
                    ->has('quizAttempts')
                    ->withAvg('quizAttempts', 'score')
                    ->withCount(['moduleCompletions', 'quizAttempts'])
                    ->orderBy('quiz_attempts_avg_score', 'desc')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('rank')
                    ->label('#')
                    ->getStateUsing(fn ($record, $rowLoop) => $rowLoop->iteration)
                    ->badge()
                    ->color(fn ($record, $rowLoop): string => match ($rowLoop->iteration) {
                        1 => 'warning',
                        2 => 'gray',
                        3 => 'danger',
                        default => 'info',
                    }),
                Tables\Columns\TextColumn::make('name')
                    ->label('Student Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('enrollments_count')
                    ->label('Enrollments')
                    ->counts('enrollments')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('module_completions_count')
                    ->label('Completed Modules')
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('quiz_attempts_count')
                    ->label('Quiz Attempts')
                    ->badge()
                    ->color('warning'),
                Tables\Columns\TextColumn::make('quiz_attempts_avg_score')
                    ->label('Average Score')
                    ->getStateUsing(function (User $record) {
                        return number_format($record->quiz_attempts_avg_score ?? 0, 1) . '%';
                    })
                    ->sortable()
                    ->badge()
                    ->color(fn (User $record): string => match (true) {
                        ($record->quiz_attempts_avg_score ?? 0) >= 80 => 'success',
                        ($record->quiz_attempts_avg_score ?? 0) >= 60 => 'warning',
                        default => 'danger',
                    })
                    ->weight('bold'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View Profile')
                    ->icon('heroicon-o-eye')
                    ->url(fn (User $record): string => route('filament.admin.resources.students.view', ['record' => $record])),
            ]);
    }
}
