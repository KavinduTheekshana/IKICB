<?php

namespace App\Filament\Branch\Resources\StudentResource\Pages;

use App\Filament\Branch\Resources\StudentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->studentDetailImage = $data['student_detail_image'] ?? null;
        unset($data['student_detail_image']);
        return $data;
    }

    protected function afterCreate(): void
    {
        if (!empty($this->studentDetailImage)) {
            $this->record->studentDetail()->updateOrCreate(
                ['user_id' => $this->record->id],
                ['image' => $this->studentDetailImage]
            );
        }
    }
}
