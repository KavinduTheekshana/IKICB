<?php

namespace App\Filament\Resources\ModuleResource\Pages;

use App\Filament\Resources\ModuleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditModule extends EditRecord
{
    protected static string $resource = ModuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Auto-generate video_url from bunny_library_id and bunny_video_id
        if (!empty($data['bunny_library_id']) && !empty($data['bunny_video_id'])) {
            $data['video_url'] = "https://iframe.mediadelivery.net/embed/{$data['bunny_library_id']}/{$data['bunny_video_id']}";
        } else {
            // If video data is removed, clear the video_url
            $data['video_url'] = null;
        }

        return $data;
    }
}
