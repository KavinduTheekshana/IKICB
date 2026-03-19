<?php

namespace App\Filament\Resources\CourseStudentMarksResource\Pages;

use App\Filament\Resources\CourseStudentMarksResource;
use Filament\Resources\Pages\ListRecords;

class ListCourseStudentMarks extends ListRecords
{
    protected static string $resource = CourseStudentMarksResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
