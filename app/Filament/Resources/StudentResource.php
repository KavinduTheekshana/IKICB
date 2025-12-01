<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StudentResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Students';

    protected static ?string $modelLabel = 'Student';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('role', 'student');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Student Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('enrollments_count')
                    ->label('Courses Enrolled')
                    ->counts('enrollments')
                    ->sortable()
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('payments_count')
                    ->label('Total Payments')
                    ->counts('payments')
                    ->sortable()
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('completed_payments_count')
                    ->label('Completed Payments')
                    ->counts([
                        'payments' => fn (Builder $query) => $query->where('status', 'completed')
                    ])
                    ->sortable()
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('module_completions_count')
                    ->label('Modules Completed')
                    ->counts('moduleCompletions')
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('quiz_attempts_count')
                    ->label('Quiz Attempts')
                    ->counts('quizAttempts')
                    ->sortable()
                    ->badge()
                    ->color('warning'),
                Tables\Columns\TextColumn::make('average_quiz_score')
                    ->label('Avg Quiz Score')
                    ->getStateUsing(function (User $record) {
                        $avgScore = $record->quizAttempts()->avg('score');
                        return $avgScore ? number_format($avgScore, 1) . '%' : 'N/A';
                    })
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->withAvg('quizAttempts', 'score')
                            ->orderBy('quiz_attempts_avg_score', $direction);
                    })
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        str_contains($state, 'N/A') => 'gray',
                        floatval($state) >= 80 => 'success',
                        floatval($state) >= 60 => 'warning',
                        default => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registered')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('has_enrollments')
                    ->label('Has Enrollments')
                    ->query(fn (Builder $query): Builder => $query->has('enrollments')),
                Tables\Filters\Filter::make('has_completions')
                    ->label('Has Completed Modules')
                    ->query(fn (Builder $query): Builder => $query->has('moduleCompletions')),
                Tables\Filters\SelectFilter::make('enrollment_count')
                    ->label('Enrollment Count')
                    ->options([
                        '1' => '1+ courses',
                        '3' => '3+ courses',
                        '5' => '5+ courses',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value'])) {
                            return $query->has('enrollments', '>=', (int)$data['value']);
                        }
                        return $query;
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('view_progress')
                    ->label('View Progress')
                    ->icon('heroicon-o-chart-bar')
                    ->color('info')
                    ->url(fn (User $record): string => StudentResource::getUrl('progress', ['record' => $record])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'view' => Pages\ViewStudent::route('/{record}'),
            'progress' => Pages\StudentProgress::route('/{record}/progress'),
        ];
    }
}
