<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class QuizAttemptsRelationManager extends RelationManager
{
    protected static string $relationship = 'quizAttempts';

    protected static ?string $title = 'Quiz Attempts';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('module.title')
                    ->label('Module')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_questions')
                    ->label('Total Questions')
                    ->sortable(),
                Tables\Columns\TextColumn::make('correct_answers')
                    ->label('Correct')
                    ->sortable(),
                Tables\Columns\TextColumn::make('score')
                    ->label('Score')
                    ->formatStateUsing(fn ($state) => number_format($state, 1) . '%')
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state >= 80 => 'success',
                        $state >= 60 => 'warning',
                        default      => 'danger',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('completed_at')
                    ->label('Attempted At')
                    ->dateTime('M d, Y h:i A')
                    ->sortable(),
            ])
            ->defaultSort('completed_at', 'desc')
            ->actions([
                Tables\Actions\DeleteAction::make()
                    ->label('Delete Attempt')
                    ->requiresConfirmation()
                    ->modalDescription('Deleting this attempt will allow the student to attempt this quiz again.'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
