<?php

namespace App\Filament\Resources\Companies\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CompaniesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sort_order')->label('الترتيب')->sortable(),
                TextColumn::make('name')->label('الاسم')->searchable()->sortable(),
                TextColumn::make('reference_code')->label('Code')->searchable()->sortable(),
                TextColumn::make('status')->label('الحالة')->badge(),
                ColorColumn::make('brand_color')->label('اللون'),
                TextColumn::make('updated_at')->label('آخر تحديث')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options([
                        'active' => 'نشطة',
                        'soon' => 'قريبًا',
                        'hidden' => 'مخفية',
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
