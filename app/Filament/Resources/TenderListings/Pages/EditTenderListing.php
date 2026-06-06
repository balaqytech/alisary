<?php

namespace App\Filament\Resources\TenderListings\Pages;

use App\Filament\Resources\TenderListings\TenderListingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTenderListing extends EditRecord
{
    protected static string $resource = TenderListingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
