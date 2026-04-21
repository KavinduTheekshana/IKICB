<?php

namespace App\Filament\Resources\ModuleResource\RelationManagers;

use App\Models\MeetingAttendance;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class MeetingsRelationManager extends RelationManager
{
    protected static string $relationship = 'meetings';

    protected static ?string $title = 'Live Meetings & Physical Classes';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Session Details')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Live Q&A – Module 1')
                            ->columnSpanFull(),

                        Forms\Components\Select::make('class_type')
                            ->label('Session Type')
                            ->options([
                                'online'   => 'Online (Google Meet / Zoom)',
                                'physical' => 'Physical Class',
                            ])
                            ->required()
                            ->default('online')
                            ->native(false)
                            ->live(),

                        Forms\Components\Select::make('meeting_type')
                            ->label('Platform')
                            ->options([
                                'google_meet' => 'Google Meet',
                                'zoom'        => 'Zoom',
                                'other'       => 'Other',
                            ])
                            ->default('google_meet')
                            ->native(false)
                            ->visible(fn (Forms\Get $get) => $get('class_type') === 'online'),

                        Forms\Components\DateTimePicker::make('starts_at')
                            ->label('Start Date & Time')
                            ->required()
                            ->seconds(false)
                            ->timezone('Asia/Colombo'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Visible to Students')
                            ->default(true),

                        Forms\Components\TextInput::make('meeting_link')
                            ->label('Meeting Link')
                            ->url()
                            ->maxLength(2048)
                            ->placeholder('https://meet.google.com/xxx-xxxx-xxx')
                            ->columnSpanFull()
                            ->visible(fn (Forms\Get $get) => $get('class_type') === 'online'),

                        Forms\Components\TextInput::make('location')
                            ->label('Venue / Location')
                            ->maxLength(500)
                            ->placeholder('e.g. Hall A, IKICB Campus, Colombo')
                            ->columnSpanFull()
                            ->visible(fn (Forms\Get $get) => $get('class_type') === 'physical'),

                        Forms\Components\Textarea::make('description')
                            ->label('Notes / Agenda')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(3),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('starts_at')
                    ->label('Date & Time')
                    ->dateTime('M d, Y  g:i A')
                    ->sortable()
                    ->timezone('Asia/Colombo'),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(35),

                Tables\Columns\BadgeColumn::make('class_type')
                    ->label('Type')
                    ->formatStateUsing(fn ($state) => $state === 'physical' ? 'Physical' : 'Online')
                    ->color(fn ($state) => $state === 'physical' ? 'warning' : 'info'),

                Tables\Columns\BadgeColumn::make('meeting_type')
                    ->label('Platform')
                    ->formatStateUsing(fn ($state) => match($state) {
                        'google_meet' => 'Google Meet',
                        'zoom'        => 'Zoom',
                        default       => 'Other',
                    })
                    ->color(fn ($state) => match($state) {
                        'google_meet' => 'success',
                        'zoom'        => 'info',
                        default       => 'gray',
                    })
                    ->visible(fn ($record) => $record?->class_type === 'online'),

                Tables\Columns\TextColumn::make('location')
                    ->label('Venue')
                    ->limit(30)
                    ->placeholder('—')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('attendances_count')
                    ->counts('attendances')
                    ->label('Attended')
                    ->badge()
                    ->color('success'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Visible')
                    ->boolean()
                    ->trueIcon('heroicon-o-eye')
                    ->falseIcon('heroicon-o-eye-slash')
                    ->trueColor('success')
                    ->falseColor('gray'),
            ])
            ->defaultSort('starts_at', 'asc')
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Add Session'),
            ])
            ->actions([
                Tables\Actions\Action::make('manage_attendance')
                    ->label('Attendance')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->color('warning')
                    ->form(function ($record) {
                        $moduleId = $record->module_id;

                        // Enrolled students (full course or module-wise)
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
                            Forms\Components\CheckboxList::make('user_ids')
                                ->label('Mark students as Present')
                                ->options($students)
                                ->default($attended)
                                ->columns(2)
                                ->searchable()
                                ->bulkToggleable(),
                        ];
                    })
                    ->action(function ($record, array $data) {
                        $userIds = $data['user_ids'] ?? [];

                        // Remove attendance for unchecked students
                        MeetingAttendance::where('module_meeting_id', $record->id)
                            ->whereNotIn('user_id', $userIds)
                            ->delete();

                        // Add attendance for checked students
                        foreach ($userIds as $userId) {
                            MeetingAttendance::firstOrCreate(
                                ['module_meeting_id' => $record->id, 'user_id' => $userId],
                                ['joined_at' => now(), 'marked_by' => auth()->id()]
                            );
                        }

                        Notification::make()
                            ->title('Attendance updated successfully')
                            ->success()
                            ->send();
                    })
                    ->modalHeading(fn ($record) => 'Manage Attendance — ' . $record->title)
                    ->modalWidth('2xl'),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
