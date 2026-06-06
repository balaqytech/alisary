<?php

namespace App\Filament\Pages;

use App\Settings\HomepageSettings as HomepageSettingsData;
use BackedEnum;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class HomepageSettings extends SettingsPage
{
    protected static string $settings = HomepageSettingsData::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $navigationLabel = 'إعدادات الصفحة الرئيسية';

    protected static ?string $title = 'إعدادات الصفحة الرئيسية';

    protected static string|UnitEnum|null $navigationGroup = 'إعدادات الموقع';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('إعدادات الصفحة الرئيسية')
                    ->tabs([
                        Tab::make('الواجهة')
                            ->schema([
                                Section::make('شرائح الواجهة')
                                    ->schema([
                                        TextInput::make('hero.eyebrow')->label('النص العلوي')->maxLength(255),
                                        TextInput::make('hero.title')->label('العنوان الاحتياطي')->maxLength(255),
                                        Repeater::make('hero.slides')
                                            ->label('الشرائح')
                                            ->schema([
                                                TextInput::make('eyebrow')->label('النص العلوي')->maxLength(255),
                                                TextInput::make('title')->label('العنوان')->required()->maxLength(255),
                                                ColorPicker::make('accent')->label('لون الحركة')->default('#B88A3C'),
                                                FileUpload::make('image_path')
                                                    ->label('صورة الخلفية')
                                                    ->disk('public')
                                                    ->visibility('public')
                                                    ->image()
                                                    ->directory('homepage/hero')
                                                    ->imageEditor(),
                                                FileUpload::make('mobile_image_path')
                                                    ->label('صورة الخلفية للجوال')
                                                    ->disk('public')
                                                    ->visibility('public')
                                                    ->image()
                                                    ->directory('homepage/hero/mobile')
                                                    ->imageEditor(),
                                            ])
                                            ->columns(2)
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2)
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('البرهان')
                            ->schema([
                                Section::make('البرهان')
                                    ->schema([
                                        TextInput::make('proof.eyebrow')->label('النص العلوي')->maxLength(255),
                                        TextInput::make('proof.title')->label('العنوان')->maxLength(255),
                                        Repeater::make('proof.items')
                                            ->label('البطاقات')
                                            ->schema([
                                                TextInput::make('label')->label('التسمية')->required()->maxLength(120),
                                                Textarea::make('text')->label('النص')->required()->rows(3),
                                            ])
                                            ->columns(2)
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2)
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('الإرث والأثر')
                            ->schema([
                                Section::make('الإرث')
                                    ->schema([
                                        TextInput::make('legacy.eyebrow')->label('عنوان صغير')->maxLength(255),
                                        TextInput::make('legacy.title')->label('العنوان')->maxLength(255),
                                        Textarea::make('legacy.lead')->label('النص التمهيدي')->rows(3)->columnSpanFull(),
                                        Repeater::make('legacy.items')
                                            ->label('المحطات')
                                            ->schema([
                                                TextInput::make('year')->label('السنة')->required()->maxLength(80),
                                                TextInput::make('title')->label('العنوان')->required()->maxLength(255),
                                                Textarea::make('text')->label('النص')->required()->rows(3)->columnSpanFull(),
                                            ])
                                            ->columns(2)
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2)
                                    ->columnSpanFull(),
                                Section::make('الأثر')
                                    ->schema([
                                        TextInput::make('impact.number')->label('رقم الأثر')->maxLength(80),
                                        TextInput::make('impact.title')->label('عنوان الأثر')->maxLength(255),
                                        Textarea::make('impact.caption')->label('وصف الأثر')->rows(3)->columnSpanFull(),
                                    ])
                                    ->columns(2)
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('الوقف والأبواب')
                            ->schema([
                                Section::make('الوقف')
                                    ->schema([
                                        TextInput::make('waqf.eyebrow')->label('عنوان الوقف الصغير')->maxLength(255),
                                        TextInput::make('waqf.title')->label('عنوان الوقف')->maxLength(255),
                                        Textarea::make('waqf.body')->label('نص الوقف')->rows(4)->columnSpanFull(),
                                        TextInput::make('waqf.number')->label('رقم الوقف')->maxLength(80),
                                        TextInput::make('waqf.number_label')->label('وصف الرقم')->maxLength(255),
                                    ])
                                    ->columns(2)
                                    ->columnSpanFull(),
                                Section::make('الأبواب')
                                    ->schema([
                                        TextInput::make('doors.eyebrow')->label('عنوان الأبواب الصغير')->maxLength(255),
                                        TextInput::make('doors.title')->label('عنوان الأبواب')->maxLength(255),
                                        Repeater::make('doors.items')
                                            ->label('الأبواب')
                                            ->schema([
                                                TextInput::make('title')->label('العنوان')->required()->maxLength(255),
                                                Textarea::make('text')->label('النص')->required()->rows(3),
                                                TextInput::make('url')->label('الرابط')->required()->maxLength(255),
                                            ])
                                            ->columns(3)
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2)
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('المؤسس والمعرض')
                            ->schema([
                                Section::make('المؤسس')
                                    ->schema([
                                        TextInput::make('founder.eyebrow')->label('عنوان المؤسس الصغير')->maxLength(255),
                                        TextInput::make('founder.title')->label('عنوان المؤسس')->maxLength(255),
                                        TextInput::make('founder.name')->label('اسم المؤسس')->maxLength(255),
                                        RichEditor::make('founder.body')->label('نص المؤسس')->columnSpanFull(),
                                        FileUpload::make('founder.image_path')
                                            ->label('صورة المؤسس')
                                            ->disk('public')
                                            ->visibility('public')
                                            ->image()
                                            ->directory('homepage/founder')
                                            ->imageEditor(),
                                    ])
                                    ->columns(2)
                                    ->columnSpanFull(),
                                Section::make('المعرض')
                                    ->schema([
                                        Repeater::make('gallery')
                                            ->label('الصور')
                                            ->schema([
                                                FileUpload::make('image_path')
                                                    ->label('الصورة')
                                                    ->disk('public')
                                                    ->visibility('public')
                                                    ->image()
                                                    ->directory('homepage/gallery')
                                                    ->imageEditor()
                                                    ->required(),
                                                TextInput::make('caption')->label('وصف قصير')->maxLength(255),
                                            ])
                                            ->columns(2)
                                            ->columnSpanFull(),
                                    ])
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }
}
