<?php

namespace App\Filament\Resources\ModuleResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MaterialsRelationManager extends RelationManager
{
    protected static string $relationship = 'materials';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Material Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('type')
                            ->options([
                                'pdf' => 'PDF Document',
                                'image' => 'Image',
                                'document' => 'Document (Word, Excel, etc.)',
                                'video' => 'Video',
                                'other' => 'Other',
                            ])
                            ->required()
                            ->default('pdf')
                            ->live(),
                        Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->default(0)
                            ->label('Display Order')
                            ->helperText('Lower numbers appear first'),
                    ])->columns(2),

                Forms\Components\Section::make('File Upload')
                    ->schema([
                        Forms\Components\FileUpload::make('file_path')
                            ->label('Upload File')
                            ->required()
                            ->directory('module-materials')
                            ->acceptedFileTypes(function (Forms\Get $get) {
                                return match($get('type')) {
                                    'pdf' => ['application/pdf'],
                                    'image' => ['image/*'],
                                    'document' => ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
                                    'video' => ['video/*'],
                                    default => ['*/*'],
                                };
                            })
                            ->maxSize(51200)
                            ->downloadable()
                            ->openable()
                            ->previewable()
                            ->columnSpanFull(),
                    ]),
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
                Tables\Columns\IconColumn::make('type')
                    ->icon(fn ($record) => match($record->type) {
                        'pdf' => 'heroicon-o-document-text',
                        'image' => 'heroicon-o-photo',
                        'video' => 'heroicon-o-film',
                        'document' => 'heroicon-o-document',
                        default => 'heroicon-o-document',
                    })
                    ->color(fn ($record) => match($record->type) {
                        'pdf' => 'danger',
                        'image' => 'success',
                        'video' => 'warning',
                        'document' => 'info',
                        default => 'gray',
                    })
                    ->label('Type')
                    ->tooltip(fn ($record) => ucfirst($record->type)),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->wrap()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('file_size_formatted')
                    ->label('Size')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'pdf' => 'PDF',
                        'image' => 'Image',
                        'document' => 'Document',
                        'video' => 'Video',
                        'other' => 'Other',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        if (isset($data['file_path'])) {
                            $file = storage_path('app/public/' . $data['file_path']);
                            if (file_exists($file)) {
                                $data['file_size'] = filesize($file);
                                $data['file_type'] = mime_content_type($file);
                            }
                        }
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        if (isset($data['file_path'])) {
                            $file = storage_path('app/public/' . $data['file_path']);
                            if (file_exists($file)) {
                                $data['file_size'] = filesize($file);
                                $data['file_type'] = mime_content_type($file);
                            }
                        }
                        return $data;
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
