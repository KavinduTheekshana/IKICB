<?php

namespace App\Filament\Resources\ModuleResource\RelationManagers;

use App\Models\ModuleVideo;
use App\Services\BunnyVideoService;
use Filament\Forms;
use Filament\Forms\Form;
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
                        Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->default(0)
                            ->label('Display Order')
                            ->helperText('Lower numbers appear first'),
                        Forms\Components\DateTimePicker::make('expires_at')
                            ->label('Expiry Date & Time')
                            ->nullable()
                            ->helperText('Leave empty for no expiry. After this date/time the video will be hidden from students.'),
                    ])->columns(2),

                Forms\Components\Section::make('Bunny.net Video')
                    ->schema([
                        Forms\Components\Placeholder::make('bunny_note')
                            ->label('')
                            ->content(new HtmlString(
                                '<div class="text-sm text-blue-700 bg-blue-50 border border-blue-200 rounded-lg p-3">'
                                . '<strong>How to get the Video ID:</strong> Upload your video directly on '
                                . '<strong>Bunny.net Stream</strong> dashboard, then copy the <strong>Video GUID</strong> '
                                . 'from the video details page and paste it below. The embed URL will be generated automatically.'
                                . '</div>'
                            ))
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('bunny_video_id')
                            ->label('Bunny Video ID (GUID)')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. 7c577ca0-74fc-4d84-8eeb-7ee50cdc4b04')
                            ->helperText('Copy the Video GUID from your Bunny.net Stream library.')
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
                                if ($record->status === 'ready' && $record->bunny_video_id) {
                                    $bunny      = app(BunnyVideoService::class);
                                    $libraryId  = $record->bunny_library_id ?: $bunny->getDefaultLibraryId();
                                    $previewUrl = $bunny->embedUrl($libraryId, $record->bunny_video_id);
                                    $frameId    = 'admin-preview-' . md5($record->bunny_video_id);
                                    $previewHtml = '
                                        <div class="mt-3 rounded-lg overflow-hidden"
                                             style="position:relative;padding-bottom:56.25%;height:0;"
                                             x-data
                                             x-init="$nextTick(() => { var f = document.getElementById(\'' . $frameId . '\'); if(f) f.src = \'' . e($previewUrl) . '\'; })">
                                            <iframe
                                                id="' . $frameId . '"
                                                frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope"
                                                sandbox="allow-scripts allow-same-origin allow-forms allow-presentation"
                                                referrerpolicy="no-referrer"
                                                allowfullscreen="true"
                                                style="border:none;position:absolute;top:0;left:0;height:100%;width:100%;">
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
                    ->mutateFormDataUsing(function (array $data): array {
                        $libraryId = config('services.bunny.library_id', '');
                        $data['bunny_library_id'] = $libraryId;
                        if (!empty($data['bunny_video_id'])) {
                            $data['video_url'] = app(BunnyVideoService::class)->embedUrl($libraryId, $data['bunny_video_id']);
                            $data['status']    = 'ready';
                        }
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $libraryId = config('services.bunny.library_id', '');
                        $data['bunny_library_id'] = $libraryId;
                        if (!empty($data['bunny_video_id'])) {
                            $data['video_url'] = app(BunnyVideoService::class)->embedUrl($libraryId, $data['bunny_video_id']);
                            $data['status']    = 'ready';
                        }
                        return $data;
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

}
