<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PopularCourses extends BaseWidget
{
    protected static ?int $sort = 6;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Popular Courses')
            ->query(
                Course::query()
                    ->withCount([
                        'enrollments',
                        'modules',
                        'payments' => function ($query) {
                            $query->where('status', 'completed');
                        },
                    ])
                    ->withSum('payments', 'amount')
                    ->orderBy('enrollments_count', 'desc')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('rank')
                    ->label('#')
                    ->getStateUsing(fn ($record, $rowLoop) => $rowLoop->iteration)
                    ->badge()
                    ->color('info'),
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->disk('public')
                    ->height(50)
                    ->defaultImageUrl('/images/course-placeholder.png'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Course Title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap(),
                Tables\Columns\TextColumn::make('instructor.name')
                    ->label('Instructor')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('enrollments_count')
                    ->label('Enrollments')
                    ->sortable()
                    ->badge()
                    ->color('success')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('modules_count')
                    ->label('Modules')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('payments_count')
                    ->label('Payments')
                    ->badge()
                    ->color('warning'),
                Tables\Columns\TextColumn::make('payments_sum_amount')
                    ->label('Total Revenue')
                    ->money('LKR')
                    ->sortable()
                    ->weight('bold')
                    ->color('success'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Course Price')
                    ->money('LKR')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View Course')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Course $record): string => route('filament.admin.resources.courses.edit', ['record' => $record])),
            ]);
    }
}
