<?php

namespace App\Filament\Resources\HomeSections\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HomeSectionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sort_order')->label('الترتيب')->sortable(),
                TextColumn::make('key')->label('المفتاح')->searchable(),
                TextColumn::make('title')->label('العنوان')->searchable()->limit(50),
                IconColumn::make('is_active')->label('مفعل')->boolean(),
                TextColumn::make('updated_at')->label('آخر تحديث')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
