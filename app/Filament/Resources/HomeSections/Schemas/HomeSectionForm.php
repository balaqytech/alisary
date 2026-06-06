<?php

namespace App\Filament\Resources\HomeSections\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HomeSectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('تعريف القسم')
                    ->schema([
                        TextInput::make('key')->label('المفتاح البرمجي')->required()->unique(ignoreRecord: true)->maxLength(255),
                        TextInput::make('title')->label('العنوان')->required()->maxLength(255),
                        TextInput::make('eyebrow')->label('التصنيف الصغير')->maxLength(255),
                        TextInput::make('sort_order')->label('الترتيب')->numeric()->required()->default(0),
                        Toggle::make('is_active')->label('مفعل')->default(true),
                    ])
                    ->columns(2),
                Section::make('محتوى القسم')
                    ->schema([
                        Textarea::make('content.lead')->label('النص التمهيدي')->rows(3),
                        TextInput::make('content.subtitle')->label('النص المساند')->maxLength(500),
                        TextInput::make('content.number')->label('الرقم البارز')->maxLength(255),
                        TextInput::make('content.caption')->label('تعليق الرقم')->maxLength(500),
                        Textarea::make('content.body')->label('النص الرئيسي')->rows(5)->columnSpanFull(),
                        Repeater::make('content.items')
                            ->label('العناصر المتكررة')
                            ->schema([
                                TextInput::make('label')->label('وسم')->maxLength(255),
                                TextInput::make('year')->label('السنة')->maxLength(255),
                                TextInput::make('title')->label('العنوان')->maxLength(255),
                                TextInput::make('url')->label('الرابط')->maxLength(255),
                                Textarea::make('text')->label('النص')->rows(3)->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),
                        KeyValue::make('content.extra')->label('حقول إضافية')->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
