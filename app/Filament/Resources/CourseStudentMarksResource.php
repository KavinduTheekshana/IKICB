<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseStudentMarksResource\Pages;
use App\Models\Course;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CourseStudentMarksResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';

    protected static ?string $navigationLabel = 'Course Student Marks';

    protected static ?string $modelLabel = 'Course Student Marks';

    protected static ?string $pluralModelLabel = 'Course Student Marks';

    protected static ?string $navigationGroup = 'Course Management';

    protected static ?int $navigationSort = 2;

    protected static ?string $slug = 'course-student-marks';

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->circular()
                    ->hidden(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Course')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('instructor.name')
                    ->label('Instructor')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('modules_count')
                    ->label('Modules')
                    ->counts('modules')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('enrollments_count')
                    ->label('Enrolled Students')
                    ->counts('enrollments')
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
