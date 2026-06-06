<?php

namespace App\Filament\Resources\Submissions\Schemas;

use App\Enums\SubmissionStatus;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SubmissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات الطلب')
                    ->schema([
                        Select::make('listing_id')->label('الإعلان')->relationship('listing', 'title')->required()->disabled(),
                        Select::make('status')
                            ->label('الحالة')
                            ->options(collect(SubmissionStatus::cases())->mapWithKeys(fn (SubmissionStatus $status): array => [$status->value => $status->label()]))
                            ->required(),
                        TextInput::make('name')->label('الاسم')->disabled(),
                        TextInput::make('email')->label('البريد الإلكتروني')->disabled(),
                        TextInput::make('phone')->label('الهاتف')->disabled(),
                    ])
                    ->columns(2),
                Section::make('الإجابات والملفات')
                    ->schema([
                        KeyValue::make('answers')->label('الإجابات')->disabled()->columnSpanFull(),
                        KeyValue::make('files')->label('الملفات')->disabled()->columnSpanFull(),
                    ]),
                Section::make('ملاحظات داخلية')
                    ->schema([
                        Textarea::make('internal_notes')->label('ملاحظات')->rows(5)->columnSpanFull(),
                    ]),
            ]);
    }
}
