<?php

namespace App\Filament\Resources\JobFamilies\Pages;

use App\Filament\Resources\JobFamilies\JobFamilyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditJobFamily extends EditRecord
{
    protected static string $resource = JobFamilyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
