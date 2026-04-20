<?php

namespace App\Filament\Branch\Resources;

use App\Filament\Branch\Resources\CourseStudentMarksResource\Pages;
use App\Models\Course;
use App\Models\Enrollment;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CourseStudentMarksResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon  = 'heroicon-o-chart-bar-square';
    protected static ?string $navigationLabel = 'Course Student Marks';
    protected static ?string $modelLabel      = 'Course Student Marks';
    protected static ?string $pluralModelLabel = 'Course Student Marks';
    protected static ?string $navigationGroup = 'Student Management';
    protected static ?int    $navigationSort  = 3;
    protected static ?string $slug            = 'course-student-marks';

    public static function getEloquentQuery(): Builder
    {
        $branchId = auth()->user()->branch_id;

        // Only show courses that have at least one enrolled student from this branch
        return parent::getEloquentQuery()
            ->whereHas('enrollments.user', fn ($q) => $q->where('branch_id', $branchId));
    }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        $branchId = auth()->user()->branch_id;

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Course')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('modules_count')
                    ->label('Modules')
                    ->counts('modules')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('branch_enrollments')
                    ->label('Branch Students Enrolled')
                    ->getStateUsing(fn (Course $record) =>
                        Enrollment::where('course_id', $record->id)
                            ->whereHas('user', fn ($q) => $q->where('branch_id', $branchId))
                            ->count()
                    )
                    ->badge()
                    ->color('success'),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\Action::make('view_marks')
                    ->label('View Student Marks')
                    ->icon('heroicon-o-chart-bar')
                    ->color('primary')
                    ->url(fn (Course $record): string => static::getUrl('marks', ['record' => $record])),
            ])
            ->defaultSort('title');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourseStudentMarks::route('/'),
            'marks' => Pages\CourseModuleMarks::route('/{record}/marks'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
