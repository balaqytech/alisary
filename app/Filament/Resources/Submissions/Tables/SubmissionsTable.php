<?php

namespace App\Filament\Resources\Submissions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SubmissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('تاريخ الطلب')->dateTime()->sortable(),
                TextColumn::make('submittable.title')->label('الإعلان')->searchable(),
                TextColumn::make('submittable_type')->label('النوع')->formatStateUsing(fn (string $state): string => class_basename($state)),
                TextColumn::make('status')->label('الحالة')->badge(),
                TextColumn::make('full_name')->label('الاسم')->searchable(),
                TextColumn::make('email')->label('البريد')->searchable(),
                TextColumn::make('phone')->label('الهاتف')->searchable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options([
                        'new' => 'جديد',
                        'reviewing' => 'قيد المراجعة',
                        'shortlisted' => 'مرشح',
                        'rejected' => 'مرفوض',
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
