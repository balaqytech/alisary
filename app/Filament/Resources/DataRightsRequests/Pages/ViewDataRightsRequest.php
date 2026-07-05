<?php

namespace App\Filament\Resources\DataRightsRequests\Pages;

use App\Enums\DataRightsRequestStatus;
use App\Filament\Resources\DataRightsRequests\DataRightsRequestResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewDataRightsRequest extends ViewRecord
{
    protected static string $resource = DataRightsRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('markInReview')
                ->label('بدء المراجعة')
                ->icon('heroicon-o-eye')
                ->color('warning')
                ->visible(fn (): bool => $this->record->status === DataRightsRequestStatus::New)
                ->action(function (): void {
                    $this->record->update(['status' => DataRightsRequestStatus::InReview]);

                    Notification::make()
                        ->title('تم نقل الطلب إلى قيد المراجعة')
                        ->success()
                        ->send();
                }),
            Action::make('resolve')
                ->label('تنفيذ الطلب')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn (): bool => $this->record->status !== DataRightsRequestStatus::Fulfilled)
                ->form([
                    DateTimePicker::make('resolved_at')
                        ->label('تاريخ التنفيذ')
                        ->default(now())
                        ->required(),
                    Textarea::make('internal_notes')
                        ->label('ملاحظات داخلية')
                        ->rows(4),
                ])
                ->action(function (array $data): void {
                    $this->record->update([
                        'status' => DataRightsRequestStatus::Fulfilled,
                        'resolved_at' => $data['resolved_at'],
                        'internal_notes' => $data['internal_notes'] ?: $this->record->internal_notes,
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
                ->visible(fn (): bool => $this->record->status !== DataRightsRequestStatus::Rejected)
                ->requiresConfirmation()
                ->form([
                    Textarea::make('internal_notes')
                        ->label('سبب أو ملاحظة الرفض')
                        ->rows(4)
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $this->record->update([
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
                ->fillForm(fn (): array => [
                    'status' => $this->record->status->value,
                    'internal_notes' => $this->record->internal_notes,
                ])
                ->action(function (array $data): void {
                    $status = DataRightsRequestStatus::from($data['status']);

                    $this->record->update([
                        'status' => $status,
                        'resolved_at' => in_array($status, [DataRightsRequestStatus::Fulfilled, DataRightsRequestStatus::Rejected], true)
                            ? ($this->record->resolved_at ?? now())
                            : null,
                        'internal_notes' => $data['internal_notes'] ?: $this->record->internal_notes,
                    ]);

                    Notification::make()
                        ->title('تم تغيير حالة الطلب')
                        ->success()
                        ->send();
                }),
            EditAction::make(),
        ];
    }
}
