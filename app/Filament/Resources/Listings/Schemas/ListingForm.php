<?php

namespace App\Filament\Resources\Listings\Schemas;

use App\Enums\CustomFieldType;
use App\Enums\ListingKind;
use App\Enums\ListingStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ListingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات الإعلان')
                    ->schema([
                        Select::make('kind')
                            ->label('النوع')
                            ->options(collect(ListingKind::cases())->mapWithKeys(fn (ListingKind $kind): array => [$kind->value => $kind->label()]))
                            ->required(),
                        Select::make('status')
                            ->label('الحالة')
                            ->options(collect(ListingStatus::cases())->mapWithKeys(fn (ListingStatus $status): array => [$status->value => $status->label()]))
                            ->required()
                            ->default(ListingStatus::Draft->value),
                        TextInput::make('title')->label('العنوان')->required()->maxLength(255),
                        TextInput::make('slug')->label('الرابط المختصر')->required()->unique(ignoreRecord: true)->maxLength(255),
                        TextInput::make('summary')->label('الملخص')->maxLength(500),
                        TextInput::make('location')->label('الموقع')->maxLength(255),
                        TextInput::make('department')->label('القسم')->maxLength(255),
                        DateTimePicker::make('published_at')->label('تاريخ النشر')->seconds(false),
                        DateTimePicker::make('closes_at')->label('تاريخ الإغلاق')->seconds(false),
                        Textarea::make('description')->label('الوصف')->required()->rows(8)->columnSpanFull(),
                        FileUpload::make('attachments')->label('مرفقات الإعلان')->multiple()->directory('listings')->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('حقول نموذج التقديم')
                    ->schema([
                        Repeater::make('form_fields')
                            ->label('الحقول')
                            ->schema([
                                TextInput::make('key')->label('المفتاح')->required()->alphaDash()->maxLength(80),
                                TextInput::make('label')->label('التسمية')->required()->maxLength(255),
                                Select::make('type')
                                    ->label('نوع الحقل')
                                    ->options(collect(CustomFieldType::cases())->mapWithKeys(fn (CustomFieldType $type): array => [$type->value => $type->label()]))
                                    ->required(),
                                Toggle::make('required')->label('إلزامي')->default(false),
                                Repeater::make('options')
                                    ->label('خيارات القائمة')
                                    ->schema([
                                        TextInput::make('label')->label('التسمية')->required(),
                                        TextInput::make('value')->label('القيمة')->required(),
                                    ])
                                    ->columns(2),
                                Select::make('accepted_file_types')
                                    ->label('أنواع الملفات')
                                    ->multiple()
                                    ->options([
                                        'pdf' => 'PDF',
                                        'doc' => 'DOC',
                                        'docx' => 'DOCX',
                                        'jpg' => 'JPG',
                                        'jpeg' => 'JPEG',
                                        'png' => 'PNG',
                                    ]),
                                TextInput::make('max_file_size_kb')->label('أقصى حجم بالكيلوبايت')->numeric()->default(5120),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
