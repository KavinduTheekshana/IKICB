<?php

namespace App\Filament\Branch\Resources\QuestionCategoryResource\Pages;

use App\Filament\Branch\Resources\QuestionCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQuestionCategories extends ListRecords
{
    protected static string $resource = QuestionCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
