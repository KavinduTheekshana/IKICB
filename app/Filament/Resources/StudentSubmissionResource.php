<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentSubmissionResource\Pages;
use App\Models\Course;
use App\Models\StudentSubmission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Services\BunnyVideoService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class StudentSubmissionResource extends Resource
{
    protected static ?string $model = StudentSubmission::class;

    protected static ?string $navigationIcon  = 'heroicon-o-paper-clip';
    protected static ?string $navigationGroup = 'Student Management';
    protected static ?string $navigationLabel = 'Student Submissions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Submission Details')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->disabled()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description')
                            ->label('Description / Reason')
                            ->disabled()
                            ->rows(4)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('student_name')
                            ->label('Student')
                            ->disabled()
                            ->afterStateHydrated(fn ($component, ?StudentSubmission $record) => $component->state($record?->user?->name ?? '—')),
                        Forms\Components\TextInput::make('file_type')
                            ->label('File Type')
                            ->disabled(),
                        Forms\Components\TextInput::make('course_name')
                            ->label('Course')
                            ->disabled()
                            ->afterStateHydrated(fn ($component, ?StudentSubmission $record) => $component->state($record?->course?->title ?? '—')),
                        Forms\Components\TextInput::make('module_name')
                            ->label('Module')
                            ->disabled()
                            ->afterStateHydrated(fn ($component, ?StudentSubmission $record) => $component->state($record?->module?->title ?? '—')),
                    ])->columns(2),

                Forms\Components\Section::make('Submitted File')
                    ->schema([
                        Forms\Components\Placeholder::make('file_preview')
                            ->label('')
                            ->content(function (?StudentSubmission $record): HtmlString {
                                if (!$record) {
                                    return new HtmlString('<p class="text-gray-400">No record</p>');
                                }

                                if ($record->isVideo() && $record->bunny_video_id) {
                                    $bunny     = app(BunnyVideoService::class);
                                    $libraryId = $record->bunny_library_id ?: $bunny->getDefaultLibraryId();
                                    $signedUrl = $bunny->signedEmbedUrl($libraryId, $record->bunny_video_id);
                                    return new HtmlString('
                                        <div class="rounded-lg overflow-hidden" style="position:relative;padding-bottom:56.25%;height:0;">
                                            <iframe src="' . e($signedUrl) . '"
                                                style="border:none;position:absolute;top:0;left:0;height:100%;width:100%;"
                                                allow="accelerometer;gyroscope;autoplay;encrypted-media;"
                                                allowfullscreen="true" loading="lazy">
                                            </iframe>
                                        </div>
                                    ');
                                }

                                if ($record->file_path) {
                                    $url = \Illuminate\Support\Facades\Storage::disk('public')->url($record->file_path);
                                    if ($record->file_type === 'image') {
                                        return new HtmlString(
                                            '<img src="' . e($url) . '" class="max-w-md rounded-lg shadow mb-2">'
                                            . '<p class="text-xs text-gray-500">Size: ' . $record->getFileSizeFormatted() . '</p>'
                                        );
                                    }
                                    return new HtmlString(
                                        '<div class="space-y-3">'
                                        . '<a href="' . e($url) . '" target="_blank" style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:#2563eb;color:#fff;border-radius:8px;font-weight:600;text-decoration:none;">'
                                        . '<svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>'
                                        . 'Download / View File</a>'
                                        . '<p style="font-size:12px;color:#6b7280;">File: ' . e(basename($record->file_path)) . ' &nbsp;|&nbsp; Size: ' . $record->getFileSizeFormatted() . '</p>'
                                        . '</div>'
                                    );
                                }

                                return new HtmlString('<p class="text-gray-400 text-sm">No file available</p>');
                            })
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Admin Review')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending'  => 'Pending',
                                'reviewed' => 'Reviewed',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ])
                            ->required(),
                        Forms\Components\DateTimePicker::make('reviewed_at')
                            ->label('Reviewed At')
                            ->nullable(),
                        Forms\Components\Textarea::make('admin_feedback')
                            ->label('Feedback to Student')
                            ->rows(4)
                            ->columnSpanFull()
                            ->placeholder('Enter feedback or comments for the student...'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(40),
                Tables\Columns\BadgeColumn::make('file_type')
                    ->label('Type')
                    ->colors([
                        'warning' => 'video',
                        'danger'  => 'pdf',
                        'success' => 'image',
                        'info'    => 'document',
                        'gray'    => 'other',
                    ]),
                Tables\Columns\TextColumn::make('course.title')
                    ->label('Course')
                    ->limit(25)
                    ->placeholder('—'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'info'    => 'reviewed',
                        'success' => 'approved',
                        'danger'  => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('reviewed_at')
                    ->label('Reviewed')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->placeholder('Not reviewed'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                // Course → Module cascading filter (rendered as 2 side-by-side columns)
                Tables\Filters\Filter::make('course_module')
                    ->columnSpan(2)
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('course_id')
                                    ->label('Course')
                                    ->placeholder('All Courses')
                                    ->options(Course::orderBy('title')->pluck('title', 'id'))
                                    ->live()
                                    ->afterStateUpdated(fn (Forms\Set $set) => $set('module_id', null)),
                                Forms\Components\Select::make('module_id')
                                    ->label('Module')
                                    ->placeholder(fn (Forms\Get $get) => $get('course_id') ? 'All Modules' : 'Select a course first')
                                    ->options(fn (Forms\Get $get) =>
                                        $get('course_id')
                                            ? Course::find($get('course_id'))
                                                ?->modules()
                                                ->orderBy('order')
                                                ->pluck('title', 'id')
                                                ->toArray()
                                            : []
                                    )
                                    ->disabled(fn (Forms\Get $get) => !$get('course_id')),
                            ]),
                    ])
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if (!empty($data['course_id'])) {
                            $course = Course::find($data['course_id']);
                            if ($course) $indicators[] = Tables\Filters\Indicator::make('Course: ' . $course->title)
                                ->removeField('course_id');
                        }
                        if (!empty($data['module_id']) && !empty($data['course_id'])) {
                            $module = Course::find($data['course_id'])?->modules()->find($data['module_id']);
                            if ($module) $indicators[] = Tables\Filters\Indicator::make('Module: ' . $module->title)
                                ->removeField('module_id');
                        }
                        return $indicators;
                    })
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['course_id'] ?? null, fn (Builder $q, $id) => $q->where('course_id', $id))
                            ->when($data['module_id'] ?? null, fn (Builder $q, $id) => $q->where('module_id', $id));
                    }),

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending'  => 'Pending',
                        'reviewed' => 'Reviewed',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),

                Tables\Filters\SelectFilter::make('file_type')
                    ->label('Type')
                    ->options([
                        'video'    => 'Video',
                        'pdf'      => 'PDF',
                        'image'    => 'Image',
                        'document' => 'Document',
                        'other'    => 'Other',
                    ]),
            ])
            ->filtersLayout(Tables\Enums\FiltersLayout::AboveContent)
            ->filtersFormColumns(4)
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Review')
                    ->mutateFormDataUsing(function (array $data): array {
                        if (empty($data['reviewed_at']) && $data['status'] !== 'pending') {
                            $data['reviewed_at'] = now();
                            $data['reviewed_by'] = auth()->id();
                        }
                        return $data;
                    }),
                Tables\Actions\DeleteAction::make()
                    ->label('Delete')
                    ->requiresConfirmation()
                    ->modalHeading('Delete Submission')
                    ->modalDescription(fn (StudentSubmission $record): string => $record->bunny_video_id
                        ? 'This will permanently delete the submission AND the video from Bunny.net. This cannot be undone.'
                        : 'This will permanently delete the submission and its uploaded file. This cannot be undone.'
                    )
                    ->modalSubmitActionLabel('Yes, delete permanently'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Delete Selected')
                        ->requiresConfirmation()
                        ->modalHeading('Delete Selected Submissions')
                        ->modalDescription('This will permanently delete all selected submissions and their files (including any Bunny.net videos). This cannot be undone.')
                        ->modalSubmitActionLabel('Yes, delete all permanently'),
                    Tables\Actions\BulkAction::make('mark_reviewed')
                        ->label('Mark as Reviewed')
                        ->icon('heroicon-o-check')
                        ->action(fn ($records) => $records->each->update([
                            'status'      => 'reviewed',
                            'reviewed_at' => now(),
                            'reviewed_by' => auth()->id(),
                        ])),
                    Tables\Actions\BulkAction::make('mark_approved')
                        ->label('Mark as Approved')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update([
                            'status'      => 'approved',
                            'reviewed_at' => now(),
                            'reviewed_by' => auth()->id(),
                        ])),
                    Tables\Actions\BulkAction::make('mark_rejected')
                        ->label('Mark as Rejected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(fn ($records) => $records->each->update([
                            'status'      => 'rejected',
                            'reviewed_at' => now(),
                            'reviewed_by' => auth()->id(),
                        ])),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudentSubmissions::route('/'),
            'edit'  => Pages\EditStudentSubmission::route('/{record}/edit'),
        ];
    }
}
