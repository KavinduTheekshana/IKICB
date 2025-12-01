<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TheoryExamResource\Pages;
use App\Filament\Resources\TheoryExamResource\RelationManagers;
use App\Models\TheoryExam;
use App\Models\Module;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TheoryExamResource extends Resource
{
    protected static ?string $model = TheoryExam::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Course Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Exam Information')
                    ->schema([
                        Forms\Components\Select::make('module_id')
                            ->label('Module')
                            ->options(Module::with('course')->get()->mapWithKeys(function ($module) {
                                return [$module->id => $module->course->title . ' - ' . $module->title];
                            }))
                            ->searchable()
                            ->required()
                            ->preload()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('title')
                            ->label('Exam Title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Final Theory Exam, Midterm Assessment')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description')
                            ->label('Exam Description')
                            ->rows(3)
                            ->placeholder('Instructions and details about the exam')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('total_marks')
                            ->label('Total Marks')
                            ->numeric()
                            ->default(100)
                            ->required()
                            ->helperText('Maximum marks for this exam'),
                    ])->columns(2),

                Forms\Components\Section::make('Exam Paper')
                    ->schema([
                        Forms\Components\FileUpload::make('exam_paper_path')
                            ->label('Upload Exam Paper (PDF)')
                            ->directory('exam-papers')
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(10240)
                            ->downloadable()
                            ->openable()
                            ->previewable()
                            ->helperText('Upload the exam question paper (PDF format, max 10MB)')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('module.course.title')
                    ->label('Course')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('module.title')
                    ->label('Module')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Exam Title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('exam_paper_path')
                    ->label('Paper')
                    ->boolean()
                    ->trueIcon('heroicon-o-document-check')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->tooltip(fn ($record) => $record->exam_paper_path ? 'Paper uploaded' : 'No paper'),
                Tables\Columns\TextColumn::make('total_marks')
                    ->label('Total Marks')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('submissions_count')
                    ->counts('submissions')
                    ->label('Submissions')
                    ->badge()
                    ->color('warning'),
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
                Tables\Filters\SelectFilter::make('module_id')
                    ->label('Module')
                    ->options(Module::with('course')->get()->mapWithKeys(function ($module) {
                        return [$module->id => $module->course->title . ' - ' . $module->title];
                    }))
                    ->searchable(),
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
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListTheoryExams::route('/'),
            'create' => Pages\CreateTheoryExam::route('/create'),
            'edit' => Pages\EditTheoryExam::route('/{record}/edit'),
        ];
    }
}
