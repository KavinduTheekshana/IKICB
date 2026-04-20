<?php

namespace App\Filament\Branch\Resources\StudentSubmissionResource\Pages;

use App\Filament\Branch\Resources\StudentSubmissionResource;
use Filament\Resources\Pages\EditRecord;

class EditStudentSubmission extends EditRecord
{
    protected static string $resource = StudentSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
