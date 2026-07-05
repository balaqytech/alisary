<?php

namespace App\Filament\Resources\DataRightsRequests\Tables;

use App\Enums\DataRightsRequestStatus;
use App\Models\DataRightsRequest;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DataRightsRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference_number')->label('الرقم المرجعي')->searchable()->sortable(),
                TextColumn::make('status')->label('الحالة')->badge()->sortable(),
                TextColumn::make('request_type')->label('نوع الطلب')->searchable(),
                TextColumn::make('email')->label('البريد الإلكتروني')->searchable(),
                TextColumn::make('created_at')->label('تاريخ الإرسال')->dateTime()->sortable(),
                TextColumn::make('resolved_at')->label('تاريخ الإغلاق')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options(collect(DataRightsRequestStatus::cases())->mapWithKeys(fn (DataRightsRequestStatus $status): array => [$status->value => $status->label()])),
                SelectFilter::make('request_type')
                    ->label('نوع الطلب')
                    ->options(collect(DataRightsRequest::REQUEST_TYPES)->mapWithKeys(fn (string $type): array => [$type => $type])),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
