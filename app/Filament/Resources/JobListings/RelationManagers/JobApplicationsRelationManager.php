<?php

namespace App\Filament\Resources\JobListings\RelationManagers;

use App\Filament\Resources\JobApplications\JobApplicationResource;
use App\Filament\Resources\JobApplications\Tables\JobApplicationsTable;
use App\Models\JobApplication;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class JobApplicationsRelationManager extends RelationManager
{
    protected static string $relationship = 'primaryJobApplications';

    protected static ?string $relatedResource = JobApplicationResource::class;

    protected static ?string $title = 'طلبات التوظيف';

    public function table(Table $table): Table
    {
        return JobApplicationsTable::configure($table)
            ->relationship(null)
            ->query(JobApplication::query()->forJobListing($this->getOwnerRecord()));
    }
}
