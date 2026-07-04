<?php

namespace App\Filament\Resources\JobFamilies\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class JobFamilyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('code')
                    ->label('Code')
                    ->required()
                    ->maxLength(16)
                    ->unique(ignoreRecord: true)
                    ->dehydrateStateUsing(fn (?string $state): ?string => $state === null ? null : Str::upper($state)),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Active',
                        'hidden' => 'Hidden',
                    ])
                    ->required()
                    ->default('active'),
                TextInput::make('sort_order')
                    ->label('Sort order')
                    ->numeric()
                    ->required()
                    ->default(0),
            ]);
    }
}
