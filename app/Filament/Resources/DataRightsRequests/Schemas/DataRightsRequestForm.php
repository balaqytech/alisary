<?php

namespace App\Filament\Resources\DataRightsRequests\Schemas;

use App\Enums\DataRightsRequestStatus;
use App\Models\DataRightsRequest;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DataRightsRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات الطلب')
                    ->schema([
                        TextInput::make('reference_number')->label('الرقم المرجعي')->disabled(),
                        Select::make('status')
                            ->label('الحالة')
                            ->required(),
                        Select::make('request_type')
                            ->label('نوع الطلب')
                            ->options(collect(DataRightsRequest::REQUEST_TYPES)->mapWithKeys(fn(string $type): array => [$type => $type]))
                            ->disabled(),
                        TextInput::make('email')->label('البريد الإلكتروني')->email()->disabled(),
                        Textarea::make('details')->label('تفاصيل الطلب')->disabled()->columnSpanFull(),
                        TextInput::make('submitted_from_url')->label('رابط الإرسال')->disabled()->columnSpanFull(),
                        TextInput::make('ip_address')->label('عنوان IP')->disabled(),
                        Textarea::make('user_agent')->label('المتصفح')->disabled()->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('المتابعة الداخلية')
                    ->schema([
                        DateTimePicker::make('resolved_at')->label('تاريخ الإغلاق'),
                        Textarea::make('internal_notes')->label('ملاحظات داخلية')->rows(5)->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
