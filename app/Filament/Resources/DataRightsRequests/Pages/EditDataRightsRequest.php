<?php

namespace App\Filament\Resources\DataRightsRequests\Pages;

use App\Filament\Resources\DataRightsRequests\DataRightsRequestResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDataRightsRequest extends EditRecord
{
    protected static string $resource = DataRightsRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
