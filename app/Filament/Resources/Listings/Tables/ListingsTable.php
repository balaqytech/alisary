<?php

namespace App\Filament\Resources\Listings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ListingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kind')->label('النوع')->badge(),
                TextColumn::make('status')->label('الحالة')->badge(),
                TextColumn::make('title')->label('العنوان')->searchable()->sortable(),
                TextColumn::make('location')->label('الموقع')->searchable(),
                TextColumn::make('closes_at')->label('الإغلاق')->dateTime()->sortable(),
                TextColumn::make('submissions_count')->label('الطلبات')->counts('submissions')->sortable(),
            ])
            ->filters([
                SelectFilter::make('kind')
                    ->label('النوع')
                    ->options([
                        'job' => 'وظيفة',
                        'tender' => 'مناقصة',
                    ]),
                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options([
                        'draft' => 'مسودة',
                        'published' => 'منشور',
                        'closed' => 'مغلق',
                    ]),
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
