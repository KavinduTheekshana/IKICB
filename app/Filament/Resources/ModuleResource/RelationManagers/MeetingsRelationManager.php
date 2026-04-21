<?php

namespace App\Filament\Resources\ModuleResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class MeetingsRelationManager extends RelationManager
{
    protected static string $relationship = 'meetings';

    protected static ?string $title = 'Live Meetings';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Meeting Details')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Live Q&A Session – Module 1')
                            ->columnSpanFull(),

                        Forms\Components\Select::make('meeting_type')
                            ->label('Platform')
                            ->options([
                                'google_meet' => 'Google Meet',
                                'zoom'        => 'Zoom',
                                'other'       => 'Other',
                            ])
                            ->required()
                            ->default('google_meet')
                            ->native(false),

                        Forms\Components\DateTimePicker::make('starts_at')
                            ->label('Start Date & Time')
                            ->required()
                            ->seconds(false)
                            ->timezone('Asia/Colombo'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Visible to Students')
                            ->default(true)
                            ->helperText('Disable to hide this meeting from the student panel'),

                        Forms\Components\TextInput::make('meeting_link')
                            ->label('Meeting Link')
                            ->required()
                            ->url()
                            ->maxLength(2048)
                            ->placeholder('https://meet.google.com/xxx-xxxx-xxx')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('description')
                            ->label('Notes / Agenda')
                            ->rows(3)
                            ->placeholder('Optional: describe what will be covered in this session')
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
                    ->limit(40),

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
                    }),

                Tables\Columns\TextColumn::make('meeting_link')
                    ->label('Link')
                    ->limit(40)
                    ->url(fn ($record) => $record->meeting_link)
                    ->openUrlInNewTab()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Visible')
                    ->boolean()
                    ->trueIcon('heroicon-o-eye')
                    ->falseIcon('heroicon-o-eye-slash')
                    ->trueColor('success')
                    ->falseColor('gray'),

                Tables\Columns\TextColumn::make('description')
                    ->label('Notes')
                    ->limit(50)
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('starts_at', 'asc')
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add Meeting'),
            ])
            ->actions([
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
