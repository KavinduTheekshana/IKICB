<?php

namespace App\Filament\Resources;

use App\Models\Course;
use App\Models\MeetingAttendance;
use App\Models\ModuleMeeting;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AttendanceResource extends Resource
{
    protected static ?string $model = ModuleMeeting::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationLabel = 'Mark Attendance';

    protected static ?string $pluralModelLabel = 'Attendance';

    protected static ?string $modelLabel = 'Session';

    protected static ?string $navigationGroup = 'Course Management';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                ModuleMeeting::query()
                    ->with(['module.course', 'attendances'])
                    ->orderByRaw("CASE WHEN DATE(starts_at) = CURDATE() THEN 0 ELSE 1 END")
                    ->orderBy('starts_at', 'asc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('starts_at')
                    ->label('Date & Time')
                    ->dateTime('M d, Y  g:i A')
                    ->timezone('Asia/Colombo')
                    ->sortable()
                    ->description(fn ($record) => $record->starts_at->isToday()
                        ? '📅 Today'
                        : ($record->starts_at->isPast() ? 'Past' : 'Upcoming')),

                Tables\Columns\TextColumn::make('title')
                    ->label('Session')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->module->title ?? ''),

                Tables\Columns\TextColumn::make('module.course.title')
                    ->label('Course')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('class_type')
                    ->label('Type')
                    ->formatStateUsing(fn ($state) => $state === 'physical' ? 'Physical' : 'Online')
                    ->color(fn ($state) => $state === 'physical' ? 'warning' : 'info'),

                Tables\Columns\TextColumn::make('location')
                    ->label('Venue / Hall')
                    ->placeholder('—')
                    ->icon('heroicon-m-map-pin')
                    ->iconColor('warning')
                    ->getStateUsing(fn ($record) => $record->class_type === 'physical' ? ($record->location ?: 'Not specified') : null)
                    ->placeholder('—')
                    ->searchable(),

                Tables\Columns\TextColumn::make('attendances_count')
                    ->counts('attendances')
                    ->label('Attended')
                    ->badge()
                    ->color('success'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->trueIcon('heroicon-o-eye')
                    ->falseIcon('heroicon-o-eye-slash'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('class_type')
                    ->label('Type')
                    ->options([
                        'online'   => 'Online',
                        'physical' => 'Physical',
                    ]),

                Tables\Filters\SelectFilter::make('course')
                    ->label('Course')
                    ->options(Course::orderBy('title')->pluck('title', 'id'))
                    ->query(fn (Builder $query, array $data) =>
                        $data['value']
                            ? $query->whereHas('module', fn ($q) => $q->where('course_id', $data['value']))
                            : $query
                    ),

                Tables\Filters\Filter::make('today')
                    ->label('Today only')
                    ->query(fn (Builder $query) => $query->whereDate('starts_at', today()))
                    ->toggle(),

                Tables\Filters\Filter::make('upcoming')
                    ->label('Upcoming')
                    ->query(fn (Builder $query) => $query->where('starts_at', '>=', now()))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\Action::make('manage_attendance')
                    ->label('Mark Attendance')
                    ->icon('heroicon-o-user-group')
                    ->color('warning')
                    ->form(function ($record) {
                        $moduleId = $record->module_id;

                        $students = User::where('role', 'student')
                            ->where(function ($q) use ($moduleId, $record) {
                                $q->whereHas('enrollments', function ($q2) use ($record) {
                                    $q2->where('course_id', $record->module->course_id)
                                       ->where('status', 'active');
                                })->orWhereHas('moduleUnlocks', function ($q2) use ($moduleId) {
                                    $q2->where('module_id', $moduleId);
                                });
                            })
                            ->orderBy('name')
                            ->pluck('name', 'id')
                            ->toArray();

                        $attended = MeetingAttendance::where('module_meeting_id', $record->id)
                            ->pluck('user_id')
                            ->toArray();

                        return [
                            Forms\Components\Placeholder::make('session_info')
                                ->label('')
                                ->content(new \Illuminate\Support\HtmlString(
                                    '<div class="text-sm bg-yellow-50 border border-yellow-300 rounded-lg p-3 mb-2">'
                                    . '<strong>' . e($record->title) . '</strong><br>'
                                    . '<span class="text-gray-600">'
                                    . e($record->starts_at->timezone('Asia/Colombo')->format('l, M d, Y  g:i A'))
                                    . ' &bull; ' . e($record->getClassTypeLabel())
                                    . ($record->location ? ' &bull; ' . e($record->location) : '')
                                    . '</span></div>'
                                ))
                                ->columnSpanFull(),

                            Forms\Components\CheckboxList::make('user_ids')
                                ->label('Present Students')
                                ->options($students)
                                ->default($attended)
                                ->columns(2)
                                ->searchable()
                                ->bulkToggleable()
                                ->columnSpanFull(),
                        ];
                    })
                    ->action(function ($record, array $data) {
                        $userIds = $data['user_ids'] ?? [];

                        MeetingAttendance::where('module_meeting_id', $record->id)
                            ->whereNotIn('user_id', $userIds)
                            ->delete();

                        foreach ($userIds as $userId) {
                            MeetingAttendance::firstOrCreate(
                                ['module_meeting_id' => $record->id, 'user_id' => $userId],
                                ['joined_at' => now(), 'marked_by' => auth()->id()]
                            );
                        }

                        Notification::make()
                            ->title('Attendance saved — ' . count($userIds) . ' student(s) marked present')
                            ->success()
                            ->send();
                    })
                    ->modalHeading(fn ($record) => 'Mark Attendance — ' . $record->title)
                    ->modalWidth('2xl'),
            ])
            ->defaultSort('starts_at', 'asc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\AttendanceResource\Pages\ListAttendance::route('/'),
        ];
    }
}
