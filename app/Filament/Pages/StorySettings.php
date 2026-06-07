<?php

namespace App\Filament\Pages;

use App\Settings\StorySettings as StorySettingsData;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
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

class StorySettings extends SettingsPage
{
    protected static string $settings = StorySettingsData::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static ?string $navigationLabel = 'إعدادات الحكاية';

    protected static ?string $title = 'إعدادات الحكاية';

    protected static string|UnitEnum|null $navigationGroup = 'إعدادات الموقع';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('إعدادات الحكاية')
                    ->tabs([
                        Tab::make('المقدمة')
                            ->schema([
                                Section::make('واجهة الحكاية')
                                    ->schema([
                                        TextInput::make('eyebrow')->label('النص العلوي')->required()->maxLength(255),
                                        TextInput::make('title')->label('العنوان')->required()->maxLength(255),
                                        Textarea::make('lead')->label('النص التمهيدي')->rows(4)->columnSpanFull(),
                                    ])
                                    ->columns(2)
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('المحتوى')
                            ->schema([
                                Section::make('المادة التحريرية')
                                    ->schema([
                                        FileUpload::make('image_path')
                                            ->label('صورة الحكاية')
                                            ->disk('public')
                                            ->visibility('public')
                                            ->image()
                                            ->directory('story')
                                            ->imageEditor(),
                                        TextInput::make('image_caption')->label('وصف الصورة')->maxLength(255),
                                        RichEditor::make('body')
                                            ->label('نص الحكاية')
                                            ->fileAttachmentsDisk('public')
                                            ->fileAttachmentsDirectory('story/rich-content')
                                            ->fileAttachmentsVisibility('public')
                                            ->columnSpanFull(),
                                        TextInput::make('closing')->label('نص الختام')->maxLength(255)->columnSpanFull(),
                                    ])
                                    ->columns(2)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }
}
