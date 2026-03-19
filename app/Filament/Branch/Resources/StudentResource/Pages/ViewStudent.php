<?php

namespace App\Filament\Branch\Resources\StudentResource\Pages;

use App\Filament\Branch\Resources\StudentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;

class ViewStudent extends ViewRecord
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('view_progress')
                ->label('View Progress')
                ->icon('heroicon-o-chart-bar')
                ->color('info')
                ->url(fn () => StudentResource::getUrl('progress', ['record' => $this->record])),
            Actions\EditAction::make(),
        ];
    }
}
