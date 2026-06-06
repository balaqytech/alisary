<?php

namespace App\Filament\Resources\JobListings\RelationManagers;

use App\Enums\SubmissionStatus;
use Filament\Actions\EditAction;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SubmissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'submissions';

    protected static ?string $title = 'طلبات التقديم';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('بيانات المتقدم')
                    ->schema([
                        Select::make('status')
                            ->label('الحالة')
                            ->options(collect(SubmissionStatus::cases())->mapWithKeys(fn (SubmissionStatus $status): array => [$status->value => $status->label()]))
                            ->required(),
                        TextInput::make('full_name')->label('الاسم الكامل')->disabled(),
                        TextInput::make('phone')->label('الهاتف')->disabled(),
                        TextInput::make('email')->label('البريد')->disabled(),
                        TextInput::make('birthday')->label('تاريخ الميلاد')->disabled(),
                        TextInput::make('cv_path')->label('السيرة الذاتية')->disabled()->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('الحقول الإضافية')
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('full_name')
            ->columns([
                TextColumn::make('created_at')->label('تاريخ الطلب')->dateTime()->sortable(),
                TextColumn::make('status')->label('الحالة')->badge()->sortable(),
                TextColumn::make('full_name')->label('الاسم')->searchable(),
                TextColumn::make('phone')->label('الهاتف')->searchable(),
                TextColumn::make('email')->label('البريد')->searchable(),
                TextColumn::make('birthday')->label('الميلاد')->date(),
                TextColumn::make('cv_path')->label('السيرة الذاتية')->limit(32),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
