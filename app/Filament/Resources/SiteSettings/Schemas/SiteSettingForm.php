<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('الهوية الأساسية')
                    ->schema([
                        TextInput::make('site_name')->label('اسم الموقع')->required()->maxLength(255),
                        TextInput::make('slogan')->label('الشعار النصي')->maxLength(255),
                        FileUpload::make('logo_path')->label('الشعار')->image()->directory('site')->imageEditor(),
                    ])
                    ->columns(2),
                Section::make('التواصل والروابط')
                    ->schema([
                        TextInput::make('email')->label('البريد الإلكتروني')->email()->maxLength(255),
                        TextInput::make('phone')->label('الهاتف')->maxLength(255),
                        TextInput::make('address')->label('العنوان')->maxLength(255),
                        TextInput::make('assistant_url')->label('رابط المساعد الذكي')->url()->maxLength(255),
                        KeyValue::make('social_links')->label('روابط التواصل')->keyLabel('المنصة')->valueLabel('الرابط'),
                    ])
                    ->columns(2),
                Section::make('محركات البحث')
                    ->schema([
                        TextInput::make('seo_title')->label('عنوان SEO')->maxLength(255),
                        Textarea::make('seo_description')->label('وصف SEO')->rows(3)->columnSpanFull(),
                    ]),
            ]);
    }
}
