<?php

namespace App\Filament\Branch\Resources\AttendanceResource\Pages;

use App\Filament\Branch\Resources\AttendanceResource;
use Filament\Resources\Pages\ListRecords;

class ListAttendance extends ListRecords
{
    protected static string $resource = AttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
