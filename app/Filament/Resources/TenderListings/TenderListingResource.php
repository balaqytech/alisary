<?php

namespace App\Filament\Resources\TenderListings;

use App\Filament\Resources\TenderListings\Pages\CreateTenderListing;
use App\Filament\Resources\TenderListings\Pages\EditTenderListing;
use App\Filament\Resources\TenderListings\Pages\ListTenderListings;
use App\Filament\Resources\TenderListings\Schemas\TenderListingForm;
use App\Filament\Resources\TenderListings\Tables\TenderListingsTable;
use App\Models\TenderListing;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TenderListingResource extends Resource
{
    protected static ?string $model = TenderListing::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'المناقصات';

    protected static ?string $modelLabel = 'مناقصة';

    protected static ?string $pluralModelLabel = 'المناقصات';

    public static function form(Schema $schema): Schema
    {
        return TenderListingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TenderListingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTenderListings::route('/'),
            'create' => CreateTenderListing::route('/create'),
            'edit' => EditTenderListing::route('/{record}/edit'),
        ];
    }
}
