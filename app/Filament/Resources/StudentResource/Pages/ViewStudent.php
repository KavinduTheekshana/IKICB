<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewStudent extends ViewRecord
{
    protected static string $resource = StudentResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Student Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label('Name'),
                        Infolists\Components\TextEntry::make('email')
                            ->label('Email')
                            ->copyable(),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Registered')
                            ->dateTime('M d, Y h:i A'),
                    ])->columns(3),

                Infolists\Components\Section::make('Statistics')
                    ->schema([
                        Infolists\Components\TextEntry::make('enrollments_count')
                            ->label('Total Enrollments')
                            ->getStateUsing(fn ($record) => $record->enrollments()->count())
                            ->badge()
                            ->color('success'),
                        Infolists\Components\TextEntry::make('completed_payments')
                            ->label('Completed Payments')
                            ->getStateUsing(fn ($record) => $record->payments()->where('status', 'completed')->count())
                            ->badge()
                            ->color('info'),
                        Infolists\Components\TextEntry::make('module_completions')
                            ->label('Modules Completed')
                            ->getStateUsing(fn ($record) => $record->moduleCompletions()->count())
                            ->badge()
                            ->color('primary'),
                        Infolists\Components\TextEntry::make('quiz_attempts')
                            ->label('Quiz Attempts')
                            ->getStateUsing(fn ($record) => $record->quizAttempts()->count())
                            ->badge()
                            ->color('warning'),
                        Infolists\Components\TextEntry::make('average_score')
                            ->label('Average Quiz Score')
                            ->getStateUsing(function ($record) {
                                $avg = $record->quizAttempts()->avg('score');
                                return $avg ? number_format($avg, 1) . '%' : 'N/A';
                            })
                            ->badge()
                            ->color('success'),
                    ])->columns(5),
            ]);
    }
}
