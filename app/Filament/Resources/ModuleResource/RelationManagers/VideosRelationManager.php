<?php

namespace App\Filament\Resources\ModuleResource\RelationManagers;

use App\Models\ModuleVideo;
use App\Services\BunnyVideoService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\HtmlString;

class VideosRelationManager extends RelationManager
{
    protected static string $relationship = 'videos';

    public function form(Form $form): Form
    {
        $defaultLibraryId = config('services.bunny.library_id', '');

        return $form
            ->schema([
                Forms\Components\Section::make('Video Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description')
                            ->rows(2)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('bunny_library_id')
                            ->label('Bunny Library ID')
                            ->required()
                            ->default($defaultLibraryId)
                            ->maxLength(255)
                            ->helperText('Find this in your Bunny Stream library settings'),
                        Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->default(0)
                            ->label('Display Order')
                            ->helperText('Lower numbers appear first'),
                        Forms\Components\DateTimePicker::make('expires_at')
                            ->label('Expiry Date & Time')
                            ->nullable()
                            ->helperText('Leave empty for no expiry. After this date/time the video will be hidden from students.')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Video Upload')
                    ->schema([
                        Forms\Components\FileUpload::make('temp_file_path')
                            ->label('Upload Video')
                            ->disk('public')
                            ->directory('temp-videos')
                            ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/ogg', 'video/avi', 'video/quicktime', 'video/x-matroska', 'video/*'])
                            ->maxSize(1024 * 10240) // 10 GB in KB
                            ->helperText('Video will be streamed to Bunny.net and removed from this server immediately after upload.')
                            ->columnSpanFull(),

                        Forms\Components\Placeholder::make('upload_note')
                            ->label('')
                            ->content(new HtmlString(
                                '<div class="text-sm text-amber-600 bg-amber-50 border border-amber-200 rounded-lg p-3">'
                                . '<strong>Note:</strong> The video is streamed directly to Bunny.net on save. '
                                . 'Large files may take several minutes — please wait for the page to respond before closing.'
                                . '</div>'
                            ))
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Current Video')
                    ->schema([
                        Forms\Components\Placeholder::make('video_preview')
                            ->label('')
                            ->content(function (?ModuleVideo $record): HtmlString {
                                if (!$record || !$record->bunny_video_id) {
                                    return new HtmlString('<p class="text-gray-400 text-sm">No video uploaded yet.</p>');
                                }

                                $statusColors = [
                                    'uploading'  => 'bg-blue-100 text-blue-800',
                                    'processing' => 'bg-yellow-100 text-yellow-800',
                                    'ready'      => 'bg-green-100 text-green-800',
                                    'failed'     => 'bg-red-100 text-red-800',
                                ];
                                $statusColor = $statusColors[$record->status] ?? 'bg-gray-100 text-gray-800';

                                $expiredHtml = $record->isExpired()
                                    ? '<span class="ml-2 px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Expired</span>'
                                    : '';

                                $previewHtml = '';
                                if ($record->status === 'ready' && $record->video_url) {
                                    $previewHtml = '
                                        <div class="mt-3 rounded-lg overflow-hidden" style="position:relative;padding-bottom:56.25%;height:0;">
                                            <iframe src="' . e($record->video_url) . '"
                                                style="border:none;position:absolute;top:0;left:0;height:100%;width:100%;"
                                                allow="accelerometer;gyroscope;autoplay;encrypted-media;picture-in-picture;"
                                                allowfullscreen="true" loading="lazy">
                                            </iframe>
                                        </div>';
                                }

                                return new HtmlString('
                                    <div>
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold ' . $statusColor . '">' . ucfirst($record->status) . '</span>
                                            ' . $expiredHtml . '
                                            <span class="text-xs text-gray-500">Video ID: ' . e($record->bunny_video_id) . '</span>
                                        </div>
                                        ' . $previewHtml . '
                                    </div>
                                ');
                            })
                            ->columnSpanFull(),
                    ])
                    ->visibleOn('edit'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->label('#')
                    ->sortable()
                    ->width(50),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'uploading',
                        'info'    => 'processing',
                        'success' => 'ready',
                        'danger'  => 'failed',
                    ]),
                Tables\Columns\TextColumn::make('expires_at')
                    ->label('Expires')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->placeholder('Never')
                    ->color(fn ($record) => $record?->isExpired() ? 'danger' : 'success'),
                Tables\Columns\TextColumn::make('bunny_video_id')
                    ->label('Video ID')
                    ->limit(20)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order', 'asc')
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(function (ModuleVideo $record): void {
                        $this->uploadToBunny($record);
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('refresh_status')
                    ->label('Refresh Status')
                    ->icon('heroicon-o-arrow-path')
                    ->color('info')
                    ->visible(fn (ModuleVideo $record) => in_array($record->status, ['uploading', 'processing']))
                    ->action(function (ModuleVideo $record): void {
                        if (!$record->bunny_video_id) {
                            return;
                        }
                        try {
                            $service = app(BunnyVideoService::class);
                            $info    = $service->getVideoStatus($record->bunny_library_id, $record->bunny_video_id);

                            // Bunny.net status codes:
                            // 0=Queued, 1=Processing, 2=Encoding,
                            // 3=Finished, 4=ResolutionFinished (both = ready)
                            // 5=Failed, 8=PresignedUploadFailed
                            $bunnyStatus = $info['status'] ?? null;
                            if (in_array($bunnyStatus, [3, 4], true)) {
                                $record->update(['status' => 'ready']);
                            } elseif (in_array($bunnyStatus, [5, 8], true)) {
                                $record->update(['status' => 'failed']);
                            } else {
                                $record->update(['status' => 'processing']);
                            }

                            Notification::make()
                                ->title('Status updated to: ' . $record->fresh()->status)
                                ->success()
                                ->send();
                        } catch (\Throwable $e) {
                            Notification::make()->title('Could not refresh status')->danger()->send();
                        }
                    }),
                Tables\Actions\EditAction::make()
                    ->after(function (ModuleVideo $record): void {
                        // Only re-upload if a new file was selected
                        if ($record->temp_file_path) {
                            $this->uploadToBunny($record);
                        }
                    }),
                Tables\Actions\DeleteAction::make()
                    ->after(function (ModuleVideo $record): void {
                        if ($record->bunny_video_id) {
                            try {
                                app(BunnyVideoService::class)->deleteVideo(
                                    $record->bunny_library_id,
                                    $record->bunny_video_id
                                );
                            } catch (\Throwable $e) {
                                Log::warning("Failed to delete Bunny video {$record->bunny_video_id}: " . $e->getMessage());
                            }
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->after(function ($records): void {
                            foreach ($records as $record) {
                                if ($record->bunny_video_id) {
                                    try {
                                        app(BunnyVideoService::class)->deleteVideo(
                                            $record->bunny_library_id,
                                            $record->bunny_video_id
                                        );
                                    } catch (\Throwable $e) {
                                        Log::warning("Failed to delete Bunny video {$record->bunny_video_id}: " . $e->getMessage());
                                    }
                                }
                            }
                        }),
                ]),
            ]);
    }

    /**
     * Upload the temp file to Bunny.net, then delete it locally.
     * Runs in the `after` callback so the file is guaranteed to be on disk.
     */
    protected function uploadToBunny(ModuleVideo $record): void
    {
        if (!$record->temp_file_path) {
            return;
        }

        // FileUpload uses disk('public') → files go to storage/app/public/
        $localPath = storage_path('app/public/' . $record->temp_file_path);

        if (!file_exists($localPath)) {
            Notification::make()
                ->title('Upload failed: temporary file not found at ' . $localPath)
                ->danger()
                ->send();
            $record->update(['status' => 'failed', 'temp_file_path' => null]);
            return;
        }

        try {
            $service    = app(BunnyVideoService::class);
            $libraryId  = $record->bunny_library_id;
            $bunnyVideo = $service->createVideo($libraryId, $record->title);
            $videoId    = $bunnyVideo['guid'];

            $service->uploadVideo($libraryId, $videoId, $localPath);

            $record->update([
                'bunny_video_id' => $videoId,
                'video_url'      => $service->embedUrl($libraryId, $videoId),
                'status'         => 'processing',
                'temp_file_path' => null,
            ]);

            Notification::make()
                ->title('Video uploaded to Bunny.net. Processing may take a few minutes.')
                ->success()
                ->send();
        } catch (\Throwable $e) {
            Log::error('Bunny video upload failed: ' . $e->getMessage());

            if (file_exists($localPath)) {
                unlink($localPath);
            }

            $record->update(['status' => 'failed', 'temp_file_path' => null]);

            Notification::make()
                ->title('Video upload failed: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }
}
