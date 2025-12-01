<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Contracts\View\View;

class StudentProgress extends Page implements HasTable
{
    use InteractsWithTable;
    use InteractsWithRecord;

    protected static string $resource = StudentResource::class;

    protected static string $view = 'filament.resources.student-resource.pages.student-progress';

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    public function getTitle(): string
    {
        return 'Student Progress: ' . $this->record->name;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->record->enrollments()->getQuery())
            ->columns([
                Tables\Columns\TextColumn::make('course.title')
                    ->label('Course')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('purchase_type')
                    ->label('Purchase Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'full_course' => 'success',
                        'module_wise' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'completed' => 'primary',
                        'inactive' => 'gray',
                        default => 'warning',
                    }),
                Tables\Columns\TextColumn::make('modules_unlocked')
                    ->label('Modules Unlocked')
                    ->getStateUsing(function ($record) {
                        $unlockedCount = $this->record->moduleUnlocks()
                            ->whereIn('module_id', $record->course->modules->pluck('id'))
                            ->count();
                        $totalModules = $record->course->modules->count();
                        return "$unlockedCount / $totalModules";
                    })
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('modules_completed')
                    ->label('Modules Completed')
                    ->getStateUsing(function ($record) {
                        $completedCount = $this->record->moduleCompletions()
                            ->whereIn('module_id', $record->course->modules->pluck('id'))
                            ->count();
                        $totalModules = $record->course->modules->count();
                        return "$completedCount / $totalModules";
                    })
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('quiz_attempts')
                    ->label('Quiz Attempts')
                    ->getStateUsing(function ($record) {
                        return $this->record->quizAttempts()
                            ->whereIn('module_id', $record->course->modules->pluck('id'))
                            ->count();
                    })
                    ->badge()
                    ->color('warning'),
                Tables\Columns\TextColumn::make('avg_quiz_score')
                    ->label('Avg Quiz Score')
                    ->getStateUsing(function ($record) {
                        $avg = $this->record->quizAttempts()
                            ->whereIn('module_id', $record->course->modules->pluck('id'))
                            ->avg('score');
                        return $avg ? number_format($avg, 1) . '%' : 'N/A';
                    })
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        str_contains($state, 'N/A') => 'gray',
                        floatval($state) >= 80 => 'success',
                        floatval($state) >= 60 => 'warning',
                        default => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Enrolled On')
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('purchase_type')
                    ->options([
                        'full_course' => 'Full Course',
                        'module_wise' => 'Module-wise',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'completed' => 'Completed',
                        'inactive' => 'Inactive',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('view_modules')
                    ->label('View Modules')
                    ->icon('heroicon-o-book-open')
                    ->modalHeading(fn ($record) => 'Module Progress - ' . $record->course->title)
                    ->modalContent(fn ($record) => view('filament.resources.student-resource.modals.module-progress', [
                        'student' => $this->record,
                        'course' => $record->course,
                    ]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close'),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
