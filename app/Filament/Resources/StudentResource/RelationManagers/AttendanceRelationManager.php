<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use App\Models\MeetingAttendance;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Form;
use Filament\Forms;

class AttendanceRelationManager extends RelationManager
{
    protected static string $relationship = 'meetingAttendances';

    protected static ?string $title = 'Attendance';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('notes')->maxLength(500),
        ]);
    }

    public function table(Table $table): Table
    {
        $userId = $this->getOwnerRecord()->id;

        $onlineCount   = MeetingAttendance::where('user_id', $userId)
            ->whereHas('meeting', fn ($q) => $q->where('class_type', 'online'))
            ->count();

        $physicalCount = MeetingAttendance::where('user_id', $userId)
            ->whereHas('meeting', fn ($q) => $q->where('class_type', 'physical'))
            ->count();

        $totalCount = $onlineCount + $physicalCount;

        return $table
            ->recordTitleAttribute('id')
            ->heading(
                "Attendance — Online: {$onlineCount}  |  Physical: {$physicalCount}  |  Total: {$totalCount}"
            )
            ->columns([
                Tables\Columns\TextColumn::make('meeting.module.course.title')
                    ->label('Course')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('meeting.module.title')
                    ->label('Module')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('meeting.title')
                    ->label('Session')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('meeting.class_type')
                    ->label('Type')
                    ->formatStateUsing(fn ($state) => $state === 'physical' ? 'Physical' : 'Online')
                    ->color(fn ($state) => $state === 'physical' ? 'warning' : 'info'),

                Tables\Columns\TextColumn::make('meeting.starts_at')
                    ->label('Session Date')
                    ->dateTime('M d, Y  g:i A')
                    ->timezone('Asia/Colombo')
                    ->sortable(),

                Tables\Columns\TextColumn::make('joined_at')
                    ->label('Marked At')
                    ->dateTime('M d, Y  g:i A')
                    ->timezone('Asia/Colombo')
                    ->sortable(),

                Tables\Columns\TextColumn::make('markedBy.name')
                    ->label('Marked By')
                    ->placeholder('Auto (Online Join)')
                    ->toggleable(),
            ])
            ->defaultSort('meeting.starts_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('class_type')
                    ->label('Session Type')
                    ->relationship('meeting', 'class_type')
                    ->options([
                        'online'   => 'Online',
                        'physical' => 'Physical',
                    ]),
            ]);
    }
}
