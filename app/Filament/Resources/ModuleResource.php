<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ModuleResource\Pages;
use App\Filament\Resources\ModuleResource\RelationManagers;
use App\Models\Module;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ModuleResource extends Resource
{
    protected static ?string $model = Module::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Course Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Module Information')
                    ->schema([
                        Forms\Components\Select::make('course_id')
                            ->label('Course')
                            ->options(Course::all()->pluck('title', 'id'))
                            ->searchable()
                            ->required()
                            ->preload()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('order')
                            ->label('Display Order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first')
                            ->required(),
                        Forms\Components\TextInput::make('module_price')
                            ->label('Module Price (LKR)')
                            ->numeric()
                            ->prefix('LKR')
                            ->helperText('Leave empty if module can only be purchased as part of full course'),
                    ])->columns(2),

                Forms\Components\Section::make('Video Content')
                    ->schema([
                        Forms\Components\TextInput::make('bunny_library_id')
                            ->label('Bunny Library ID')
                            ->maxLength(255)
                            ->placeholder('Enter your Bunny Library ID')
                            ->helperText('Find this in your Bunny.net dashboard')
                            ->live(onBlur: true),
                        Forms\Components\TextInput::make('bunny_video_id')
                            ->label('Bunny Video ID')
                            ->maxLength(255)
                            ->placeholder('Enter the Video ID')
                            ->helperText('The unique ID of your uploaded video')
                            ->live(onBlur: true),
                        Forms\Components\Hidden::make('video_url')
                            ->default(function (Forms\Get $get) {
                                $libraryId = $get('bunny_library_id');
                                $videoId = $get('bunny_video_id');
                                if (!empty($libraryId) && !empty($videoId)) {
                                    return "https://iframe.mediadelivery.net/embed/{$libraryId}/{$videoId}";
                                }
                                return null;
                            })
                            ->dehydrated(),
                        Forms\Components\Placeholder::make('video_preview')
                            ->label('Video Preview')
                            ->content(function (Forms\Get $get) {
                                $libraryId = $get('bunny_library_id');
                                $videoId = $get('bunny_video_id');

                                if (empty($libraryId) || empty($videoId)) {
                                    return new \Illuminate\Support\HtmlString('<div class="text-gray-500 text-sm">Enter Library ID and Video ID above to see preview</div>');
                                }

                                $videoUrl = "https://iframe.mediadelivery.net/embed/{$libraryId}/{$videoId}";

                                return new \Illuminate\Support\HtmlString('
                                    <div class="rounded-lg overflow-hidden border border-gray-200" style="position: relative; padding-bottom: 56.25%; height: 0;">
                                        <iframe
                                            src="' . e($videoUrl) . '"
                                            loading="lazy"
                                            style="border: none; position: absolute; top: 0; left: 0; height: 100%; width: 100%;"
                                            allow="accelerometer; gyroscope; autoplay; encrypted-media; picture-in-picture;"
                                            allowfullscreen="true">
                                        </iframe>
                                    </div>
                                ');
                            })
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('course.title')
                    ->label('Course')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Module Title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order')
                    ->label('#')
                    ->sortable()
                    ->width(50),
                Tables\Columns\IconColumn::make('video_url')
                    ->label('Video')
                    ->boolean()
                    ->trueIcon('heroicon-o-video-camera')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('module_price')
                    ->label('Price')
                    ->money('LKR')
                    ->sortable()
                    ->placeholder('Included in course'),
                Tables\Columns\TextColumn::make('materials_count')
                    ->counts('materials')
                    ->label('Materials')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('course_id')
                    ->label('Course')
                    ->options(Course::all()->pluck('title', 'id'))
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\MaterialsRelationManager::class,
            RelationManagers\QuestionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListModules::route('/'),
            'create' => Pages\CreateModule::route('/create'),
            'edit' => Pages\EditModule::route('/{record}/edit'),
        ];
    }
}
