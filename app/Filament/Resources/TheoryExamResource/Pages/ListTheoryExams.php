<?php

namespace App\Filament\Resources\TheoryExamResource\Pages;

use App\Filament\Resources\TheoryExamResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTheoryExams extends ListRecords
{
    protected static string $resource = TheoryExamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
