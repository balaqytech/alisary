<?php

namespace App\Filament\Resources\JobListings\Pages;

use App\Filament\Resources\JobListings\JobListingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewJobListing extends ViewRecord
{
    protected static string $resource = JobListingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
