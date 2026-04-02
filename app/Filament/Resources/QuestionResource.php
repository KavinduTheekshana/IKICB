<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionResource\Pages;
use App\Filament\Resources\QuestionResource\RelationManagers;
use App\Models\Question;
use App\Models\QuestionCategory;
use Filament\Forms;
use Illuminate\Support\Str;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationGroup = 'Question Bank';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Question Details')
                    ->schema([
                        Forms\Components\Select::make('question_category_id')
                            ->label('Category')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required(),
                                Forms\Components\Textarea::make('description'),
                            ]),
                        Forms\Components\Select::make('type')
                            ->options([
                                'mcq' => 'Multiple Choice (MCQ)',
                                'theory' => 'Theory',
                            ])
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn ($state, Forms\Set $set) => $state === 'theory' ? $set('correct_answer', null) : null),
                        Forms\Components\Textarea::make('question')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('marks')
                            ->required()
                            ->numeric()
                            ->default(1)
                            ->minValue(1),
                    ])->columns(2),

                Forms\Components\Section::make('MCQ Options')
                    ->schema([
                        Forms\Components\Repeater::make('mcq_options')
                            ->label('Answer Options')
                            ->schema([
                                Forms\Components\Hidden::make('id')
                                    ->default(fn () => (string) Str::uuid()),
                                Forms\Components\TextInput::make('option')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->minItems(2)
                            ->maxItems(6)
                            ->defaultItems(4)
                            ->columnSpanFull()
                            ->live()
                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                                // Ensure every option has an id
                                $options = $get('mcq_options') ?? [];
                                $changed = false;
                                foreach ($options as $key => $opt) {
                                    if (is_array($opt) && empty($opt['id'])) {
                                        $options[$key]['id'] = (string) Str::uuid();
                                        $changed = true;
                                    }
                                }
                                if ($changed) {
                                    $set('mcq_options', $options);
                                }

                                // Reset correct_answer if the selected id is no longer in the list
                                $currentCorrect = $get('correct_answer');
                                $optionIds = collect($options)
                                    ->pluck('id')
                                    ->filter()
                                    ->toArray();
                                if ($currentCorrect && !in_array($currentCorrect, $optionIds)) {
                                    $set('correct_answer', null);
                                }
                            }),
                        Forms\Components\Select::make('correct_answer')
                            ->label('Correct Answer')
                            ->helperText('Select the correct answer from the options above')
                            ->options(function (Forms\Get $get) {
                                $options = $get('mcq_options') ?? [];
                                return collect($options)
                                    ->filter(fn($opt) => is_array($opt) && !empty($opt['id']) && !empty($opt['option']))
                                    ->mapWithKeys(fn($opt) => [$opt['id'] => $opt['option']])
                                    ->toArray();
                            })
                            ->required()
                            ->searchable()
                            ->native(false)
                            ->placeholder('— select correct answer —'),
                    ])
                    ->visible(fn (Forms\Get $get) => $get('type') === 'mcq'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question')
                    ->limit(50)
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('type')
                    ->colors([
                        'success' => 'mcq',
                        'warning' => 'theory',
                    ]),
                Tables\Columns\TextColumn::make('marks')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('modules_count')
                    ->counts('modules')
                    ->label('Modules')
                    ->badge()
                    ->color('info')
                    ->tooltip(fn ($record) => 'Assigned to ' . $record->modules_count . ' module(s)'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'mcq' => 'MCQ',
                        'theory' => 'Theory',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ModulesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}