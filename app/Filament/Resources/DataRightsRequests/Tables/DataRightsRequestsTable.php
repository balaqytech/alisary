<?php

namespace App\Filament\Resources\DataRightsRequests\Tables;

use App\Enums\DataRightsRequestStatus;
use App\Models\DataRightsRequest;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
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
                    ->options(collect(DataRightsRequestStatus::cases())->mapWithKeys(fn (DataRightsRequestStatus $status): array => [$status->value => $status->getLabel()])),
                SelectFilter::make('request_type')
                    ->label('نوع الطلب')
                    ->options(collect(DataRightsRequest::REQUEST_TYPES)->mapWithKeys(fn (string $type): array => [$type => $type])),
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('markInReview')
                    ->label('بدء المراجعة')
                    ->icon('heroicon-o-eye')
                    ->color('warning')
                    ->visible(fn (DataRightsRequest $record): bool => $record->status === DataRightsRequestStatus::New)
                    ->action(function (DataRightsRequest $record): void {
                        $record->update(['status' => DataRightsRequestStatus::InReview]);

                        Notification::make()
                            ->title('تم نقل الطلب إلى قيد المراجعة')
                            ->success()
                            ->send();
                    }),
                Action::make('resolve')
                    ->label('تنفيذ الطلب')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (DataRightsRequest $record): bool => $record->status !== DataRightsRequestStatus::Fulfilled)
                    ->form([
                        DateTimePicker::make('resolved_at')
                            ->label('تاريخ التنفيذ')
                            ->default(now())
                            ->required(),
                        Textarea::make('internal_notes')
                            ->label('ملاحظات داخلية')
                            ->rows(4),
                    ])
                    ->action(function (DataRightsRequest $record, array $data): void {
                        $record->update([
                            'status' => DataRightsRequestStatus::Fulfilled,
                            'resolved_at' => $data['resolved_at'],
                            'internal_notes' => $data['internal_notes'] ?: $record->internal_notes,
                        ]);

                        Notification::make()
                            ->title('تم تنفيذ طلب الحق')
                            ->success()
                            ->send();
                    }),
                Action::make('reject')
                    ->label('رفض الطلب')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (DataRightsRequest $record): bool => $record->status !== DataRightsRequestStatus::Rejected)
                    ->requiresConfirmation()
                    ->form([
                        Textarea::make('internal_notes')
                            ->label('سبب أو ملاحظة الرفض')
                            ->rows(4)
                            ->required(),
                    ])
                    ->action(function (DataRightsRequest $record, array $data): void {
                        $record->update([
                            'status' => DataRightsRequestStatus::Rejected,
                            'resolved_at' => now(),
                            'internal_notes' => $data['internal_notes'],
                        ]);

                        Notification::make()
                            ->title('تم رفض الطلب')
                            ->success()
                            ->send();
                    }),
                Action::make('changeStatus')
                    ->label('تغيير الحالة')
                    ->icon('heroicon-o-adjustments-horizontal')
                    ->form([
                        Select::make('status')
                            ->label('الحالة')
                            ->options(collect(DataRightsRequestStatus::cases())->mapWithKeys(fn (DataRightsRequestStatus $status): array => [$status->value => $status->getLabel()]))
                            ->required(),
                        Textarea::make('internal_notes')
                            ->label('ملاحظات داخلية')
                            ->rows(4),
                    ])
                    ->fillForm(fn (DataRightsRequest $record): array => [
                        'status' => $record->status->value,
                        'internal_notes' => $record->internal_notes,
                    ])
                    ->action(function (DataRightsRequest $record, array $data): void {
                        $status = DataRightsRequestStatus::from($data['status']);

                        $record->update([
                            'status' => $status,
                            'resolved_at' => in_array($status, [DataRightsRequestStatus::Fulfilled, DataRightsRequestStatus::Rejected], true)
                                ? ($record->resolved_at ?? now())
                                : null,
                            'internal_notes' => $data['internal_notes'] ?: $record->internal_notes,
                        ]);

                        Notification::make()
                            ->title('تم تغيير حالة الطلب')
                            ->success()
                            ->send();
                    }),
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
