<?php

namespace App\Filament\Branch\Resources\CourseResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ModulesRelationManager extends RelationManager
{
    protected static string $relationship = 'modules';

    public function isReadOnly(): bool
    {
        return true;
    }

    public function form(Form $form): Form
    {
        return $form->schema([]);
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
                Tables\Columns\TextColumn::make('title')
                    ->label('Module Title')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(60)
                    ->wrap(),
                Tables\Columns\TextColumn::make('module_price')
                    ->label('Price (LKR)')
                    ->money('LKR'),
                Tables\Columns\IconColumn::make('is_free')
                    ->label('Free')
                    ->boolean(),
            ])
            ->defaultSort('order', 'asc')
            ->filters([])
            ->headerActions([])
            ->actions([])
            ->bulkActions([]);
    }
}
