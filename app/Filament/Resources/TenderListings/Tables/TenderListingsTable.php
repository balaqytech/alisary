<?php

namespace App\Filament\Resources\TenderListings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TenderListingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('status')->label('الحالة')->badge()->sortable(),
                TextColumn::make('title')->label('العنوان')->searchable()->sortable(),
                TextColumn::make('contractor.name')->label('الجهة')->searchable(),
                TextColumn::make('location')->label('الموقع')->badge(),
                TextColumn::make('published_at')->label('النشر')->dateTime()->sortable(),
                TextColumn::make('last_day_to_apply')->label('آخر يوم')->dateTime()->sortable(),
                TextColumn::make('submissions_count')->label('الطلبات')->counts('submissions')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options([
                        'draft' => 'مسودة',
                        'published' => 'منشور',
                        'closed' => 'مغلق',
                    ]),
                SelectFilter::make('contractor_id')
                    ->label('الجهة')
                    ->relationship('contractor', 'name')
                    ->searchable()
                    ->preload(),
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
