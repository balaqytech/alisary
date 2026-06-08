<?php

namespace App\Filament\Resources\JobListings\Schemas;

use App\Enums\JobType;
use App\Enums\ListingLocation;
use App\Enums\ListingStatus;
use App\Filament\Forms\CustomFieldBuilder;
use App\Support\DefaultJobApplicationForm;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class JobListingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات الوظيفة')
                    ->schema([
                        Select::make('status')
                            ->label('الحالة')
                            ->options(collect(ListingStatus::cases())->mapWithKeys(fn (ListingStatus $status): array => [$status->value => $status->label()]))
                            ->required()
                            ->default(ListingStatus::Draft->value),
                        DateTimePicker::make('published_at')
                            ->label('تاريخ النشر')
                            ->seconds(false),
                        TextInput::make('title')
                            ->label('العنوان')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->label('الرابط المختصر')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Select::make('company_id')
                            ->label('الشركة')
                            ->relationship('company', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('type')
                            ->label('نوع الوظيفة')
                            ->options(collect(JobType::cases())->mapWithKeys(fn (JobType $type): array => [$type->value => $type->label()]))
                            ->required(),
                        Select::make('location')
                            ->label('الموقع')
                            ->options(collect(ListingLocation::cases())->mapWithKeys(fn (ListingLocation $location): array => [$location->value => $location->label()]))
                            ->required(),
                        DateTimePicker::make('expires_at')
                            ->label('تاريخ انتهاء التقديم')
                            ->seconds(false),
                        Textarea::make('excerpt')
                            ->label('الملخص')
                            ->maxLength(500)
                            ->rows(3)
                            ->columnSpanFull(),
                        RichEditor::make('description')
                            ->label('الوصف')
                            ->required()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('listings/jobs/rich-content')
                            ->fileAttachmentsVisibility('public')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('حقول نموذج التقديم')
                    ->schema([
                        Repeater::make('form_fields')
                            ->label('أقسام نموذج التقديم')
                            ->default(DefaultJobApplicationForm::sections())
                            ->schema([
                                TextInput::make('title')
                                    ->label('عنوان القسم')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('description')
                                    ->label('وصف قصير')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                Repeater::make('fields')
                                    ->label('حقول القسم')
                                    ->schema(CustomFieldBuilder::schema())
                                    ->columns(2)
                                    ->addActionLabel('إضافة حقل')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->addActionLabel('إضافة قسم')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
