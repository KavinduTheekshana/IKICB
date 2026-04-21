<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudent extends EditRecord
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['student_detail_image'] = $this->record->studentDetail?->image;
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $image = $data['student_detail_image'] ?? null;
        unset($data['student_detail_image']);

        $this->record->studentDetail()->updateOrCreate(
            ['user_id' => $this->record->id],
            ['image' => $image]
        );

        return $data;
    }
}
