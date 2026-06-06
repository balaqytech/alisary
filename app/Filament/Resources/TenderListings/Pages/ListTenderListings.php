<?php

namespace App\Filament\Resources\TenderListings\Pages;

use App\Filament\Resources\TenderListings\TenderListingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTenderListings extends ListRecords
{
    protected static string $resource = TenderListingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
