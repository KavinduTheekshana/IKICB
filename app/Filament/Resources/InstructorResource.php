<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InstructorResource\Pages;
use App\Filament\Resources\InstructorResource\RelationManagers;
use App\Models\Instructor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InstructorResource extends Resource
{
    protected static ?string $model = Instructor::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Team Management';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Instructor Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(191)
                            ->label('Full Name')
                            ->placeholder('Enter instructor\'s full name'),
                        Forms\Components\TextInput::make('position')
                            ->required()
                            ->maxLength(191)
                            ->label('Position/Title')
                            ->placeholder('e.g., Senior Instructor, Instructor')
                            ->helperText('The job title or position of the instructor'),
                    ])->columns(2),

                Forms\Components\Section::make('Qualifications')
                    ->schema([
                        Forms\Components\Repeater::make('qualifications')
                            ->simple(
                                Forms\Components\TextInput::make('item')
                                    ->label('Qualification')
                                    ->required()
                                    ->placeholder('e.g., NVQ Level 4 Beautician & Hairdresser')
                            )
                            ->required()
                            ->minItems(1)
                            ->defaultItems(1)
                            ->addActionLabel('Add Another Qualification')
                            ->columnSpanFull()
                            ->helperText('Add all professional qualifications and certifications'),
                    ]),

                Forms\Components\Section::make('Display Settings')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->directory('instructors')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                            ])
                            ->maxSize(2048)
                            ->helperText('Upload instructor photo (1:1 aspect ratio recommended, max 2MB)')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('order')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->label('Display Order')
                            ->helperText('Lower numbers appear first'),
                        Forms\Components\Toggle::make('is_active')
                            ->required()
                            ->default(true)
                            ->label('Active')
                            ->helperText('Show/hide this instructor on the website'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->circular()
                    ->defaultImageUrl(url('/images/default-avatar.png'))
                    ->size(50),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Instructor $record): string => $record->position),
                Tables\Columns\TextColumn::make('qualifications')
                    ->badge()
                    ->separator(',')
                    ->limit(50)
                    ->tooltip(function (Instructor $record): ?string {
                        if (empty($record->qualifications)) {
                            return null;
                        }
                        return implode(', ', $record->qualifications);
                    }),
                Tables\Columns\TextColumn::make('order')
                    ->numeric()
                    ->sortable()
                    ->label('Order')
                    ->alignCenter(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All instructors')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInstructors::route('/'),
            'create' => Pages\CreateInstructor::route('/create'),
            'edit' => Pages\EditInstructor::route('/{record}/edit'),
        ];
    }
}
