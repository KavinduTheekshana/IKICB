<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionResource\Pages;
use App\Filament\Resources\QuestionResource\RelationManagers;
use App\Models\Question;
use App\Models\QuestionCategory;
use Filament\Forms;
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
                                Forms\Components\TextInput::make('option')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->minItems(2)
                            ->maxItems(6)
                            ->defaultItems(4)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('correct_answer')
                            ->label('Correct Answer')
                            ->helperText('Enter the exact text of the correct option')
                            ->maxLength(255),
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
            //
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
