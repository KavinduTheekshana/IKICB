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
                        // Hidden field — populated by the tus upload JS below
                        Forms\Components\Hidden::make('bunny_video_id'),

                        Forms\Components\Placeholder::make('tus_uploader')
                            ->label('Upload Video')
                            ->content(new HtmlString(<<<'HTML'
<div
    x-data="{
        file: null,
        progress: 0,
        status: 'idle',
        errorMsg: '',
        filename: '',
        selectFile(e) {
            this.file = e.target.files[0];
            this.filename = this.file ? this.file.name : '';
            this.status = 'idle';
            this.progress = 0;
            this.errorMsg = '';
        },
        loadTus() {
            return new Promise((resolve, reject) => {
                if (window.tus) { resolve(); return; }
                const s = document.createElement('script');
                s.src = 'https://cdn.jsdelivr.net/npm/tus-js-client@4/dist/tus.min.js';
                s.onload = resolve;
                s.onerror = () => reject(new Error('Failed to load tus-js-client'));
                document.head.appendChild(s);
            });
        },
        async upload() {
            if (!this.file) return;
            await this.loadTus();
            this.status = 'preparing';
            this.errorMsg = '';
            const csrf = document.querySelector('meta[name=csrf-token]').content;
            // Filament v3 table-action modals store form data under mountedTableActionsData.0
            const title = this.$wire.get('mountedTableActionsData.0.title') || 'Untitled';
            const libraryId = this.$wire.get('mountedTableActionsData.0.bunny_library_id') || '';
            try {
                const prep = await fetch('/admin-api/bunny-prepare-video', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                    body: JSON.stringify({ title, library_id: libraryId }),
                });
                const prepText = await prep.text();
                if (!prep.ok) {
                    let msg = 'HTTP ' + prep.status;
                    try { const j = JSON.parse(prepText); msg = j.error || j.message || msg; } catch(_) {}
                    throw new Error(msg);
                }
                const { video_id, library_id, signature, expiry } = JSON.parse(prepText);
                this.status = 'uploading';
                const self = this;
                await new Promise((resolve, reject) => {
                    const up = new tus.Upload(self.file, {
                        endpoint: 'https://video.bunnycdn.com/tusupload',
                        retryDelays: [0, 3000, 5000, 10000, 20000],
                        headers: { AuthorizationSignature: signature, AuthorizationExpire: String(expiry), VideoId: video_id, LibraryId: String(library_id) },
                        metadata: { filetype: self.file.type, title },
                        onError(err) { reject(err); },
                        onProgress(b, t) { self.progress = Math.round(b/t*100); },
                        onSuccess() { resolve(video_id); },
                    });
                    up.start();
                });
                this.$wire.set('mountedTableActionsData.0.bunny_video_id', video_id);
                this.status = 'done';
            } catch(err) {
                this.status = 'error';
                this.errorMsg = err.message || 'Upload failed';
            }
        }
    }"
    class="space-y-3"
>

    <!-- File picker -->
    <div class="flex items-center gap-3">
        <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 rounded-lg border-2 border-dashed border-gray-300 hover:border-primary-400 bg-white text-sm font-medium text-gray-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.069A1 1 0 0121 8.882v6.235a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            <span x-text="filename || 'Choose video file'"></span>
            <input type="file" accept="video/mp4,video/webm,video/ogg,video/avi,video/quicktime,video/x-matroska" class="sr-only" @change="selectFile($event)">
        </label>
        <button type="button"
            @click="upload()"
            :disabled="!file || status === 'uploading' || status === 'preparing' || status === 'done'"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-primary-600 hover:bg-primary-700 disabled:opacity-40 disabled:cursor-not-allowed text-white text-sm font-semibold transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
            <span x-text="status === 'preparing' ? 'Preparing…' : status === 'uploading' ? 'Uploading…' : status === 'done' ? 'Uploaded ✓' : 'Upload to Bunny.net'"></span>
        </button>
    </div>

    <!-- Progress bar -->
    <div x-show="status === 'uploading' || status === 'preparing'" class="space-y-1">
        <div class="flex justify-between text-xs text-gray-500">
            <span x-text="status === 'preparing' ? 'Preparing upload…' : 'Uploading directly to Bunny.net…'"></span>
            <span x-text="progress + '%'"></span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
            <div class="h-2 rounded-full bg-primary-500 transition-all duration-300" :style="'width:' + progress + '%'"></div>
        </div>
    </div>

    <!-- Success -->
    <div x-show="status === 'done'" class="text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg p-3 flex items-center gap-2">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Video uploaded to Bunny.net. Now click <strong>Save</strong> to store the record.
    </div>

    <!-- Error -->
    <div x-show="status === 'error'" class="text-sm text-red-700 bg-red-50 border border-red-200 rounded-lg p-3" x-text="errorMsg"></div>

    <!-- Idle note -->
    <div x-show="status === 'idle'" class="text-xs text-amber-600 bg-amber-50 border border-amber-200 rounded-lg p-3">
        <strong>Direct upload:</strong> Video goes straight to Bunny.net — this server handles zero bytes.
    </div>
</div>
HTML))
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
                                    $bunny     = app(BunnyVideoService::class);
                                    $libraryId = $record->bunny_library_id ?: $bunny->getDefaultLibraryId();
                                    $previewUrl = $bunny->signedEmbedUrl($libraryId, $record->bunny_video_id);
                                    $previewHtml = '
                                        <div class="mt-3 rounded-lg overflow-hidden" style="position:relative;padding-bottom:56.25%;height:0;">
                                            <iframe src="' . e($previewUrl) . '"
                                                style="border:none;position:absolute;top:0;left:0;height:100%;width:100%;"
                                                allow="accelerometer;gyroscope;autoplay;encrypted-media;"
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
                        if ($record->bunny_video_id) {
                            $service = app(BunnyVideoService::class);
                            $record->update([
                                'video_url' => $service->embedUrl($record->bunny_library_id, $record->bunny_video_id),
                                'status'    => 'processing',
                            ]);
                        }
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
                        // Recompute video_url whenever bunny_video_id is present but url is missing or stale
                        if ($record->bunny_video_id) {
                            $service    = app(BunnyVideoService::class);
                            $freshUrl   = $service->embedUrl($record->bunny_library_id, $record->bunny_video_id);
                            if ($record->video_url !== $freshUrl || $record->status === 'uploading') {
                                $record->update([
                                    'video_url' => $freshUrl,
                                    'status'    => 'processing',
                                ]);
                            }
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

}
