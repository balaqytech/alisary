<?php

namespace App\Filament\Resources\Companies\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CompanyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات الشركة')
                    ->schema([
                        TextInput::make('name')->label('الاسم')->required()->maxLength(255),
                        TextInput::make('slug')->label('الرابط المختصر')->required()->unique(ignoreRecord: true)->maxLength(255),
                        TextInput::make('website_url')->label('رابط الموقع')->url()->maxLength(255),
                        Select::make('status')->label('الحالة')->options([
                            'active' => 'نشطة',
                            'soon' => 'قريبًا',
                            'hidden' => 'مخفية',
                        ])->required()->default('active'),
                        ColorPicker::make('brand_color')->label('لون العلامة')->required()->default('#1C463C'),
                        TextInput::make('sort_order')->label('الترتيب')->numeric()->required()->default(0),
                        Textarea::make('description')->label('الوصف')->required()->rows(4)->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('الأصول البصرية')
                    ->schema([
                        FileUpload::make('logo_path')->label('الشعار')->image()->directory('companies/logos')->imageEditor(),
                        FileUpload::make('image_path')->label('الصورة')->image()->directory('companies/images')->imageEditor(),
                    ])
                    ->columns(2),
            ]);
    }
}
