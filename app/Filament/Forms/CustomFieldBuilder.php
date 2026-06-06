<?php

namespace App\Filament\Forms;

use App\Enums\CustomFieldType;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class CustomFieldBuilder
{
    /**
     * @return array<int, mixed>
     */
    public static function schema(): array
    {
        return [
            TextInput::make('key')
                ->label('المفتاح')
                ->helperText('حروف إنجليزية وأرقام وشرطات فقط، مثال: experience_years')
                ->required()
                ->alphaDash()
                ->maxLength(80),
            TextInput::make('label')
                ->label('التسمية')
                ->required()
                ->maxLength(255),
            Select::make('type')
                ->label('نوع الحقل')
                ->options(collect(CustomFieldType::cases())->mapWithKeys(fn (CustomFieldType $type): array => [$type->value => $type->label()]))
                ->required()
                ->default(CustomFieldType::Text->value),
            Toggle::make('required')
                ->label('إلزامي')
                ->default(false),
            Repeater::make('options')
                ->label('خيارات القائمة')
                ->schema([
                    TextInput::make('label')->label('التسمية')->required(),
                    TextInput::make('value')->label('القيمة')->required()->alphaDash(),
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
            TextInput::make('max_file_size_kb')
                ->label('أقصى حجم بالكيلوبايت')
                ->numeric()
                ->default(5120),
        ];
    }
}
