<?php

namespace App\Filament\Resources\DataRightsRequests;

use App\Filament\Resources\DataRightsRequests\Pages\EditDataRightsRequest;
use App\Filament\Resources\DataRightsRequests\Pages\ListDataRightsRequests;
use App\Filament\Resources\DataRightsRequests\Pages\ViewDataRightsRequest;
use App\Filament\Resources\DataRightsRequests\Schemas\DataRightsRequestForm;
use App\Filament\Resources\DataRightsRequests\Schemas\DataRightsRequestInfolist;
use App\Filament\Resources\DataRightsRequests\Tables\DataRightsRequestsTable;
use App\Models\DataRightsRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DataRightsRequestResource extends Resource
{
    protected static ?string $model = DataRightsRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static ?string $navigationLabel = 'طلبات حقوق البيانات';

    protected static ?string $pluralModelLabel = 'طلبات حقوق البيانات';

    protected static ?string $modelLabel = 'طلب حقوق بيانات';

    protected static ?int $navigationSort = 30;

    public static function form(Schema $schema): Schema
    {
        return DataRightsRequestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DataRightsRequestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DataRightsRequestsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDataRightsRequests::route('/'),
            'view' => ViewDataRightsRequest::route('/{record}'),
            'edit' => EditDataRightsRequest::route('/{record}/edit'),
        ];
    }
}
