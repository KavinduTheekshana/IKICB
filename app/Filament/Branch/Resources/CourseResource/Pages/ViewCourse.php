<?php

namespace App\Filament\Branch\Resources\CourseResource\Pages;

use App\Filament\Branch\Resources\CourseResource;
use Filament\Resources\Pages\ViewRecord;

class ViewCourse extends ViewRecord
{
    protected static string $resource = CourseResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
