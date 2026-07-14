<?php

namespace App\Filament\Resources\JobApplications\Pages;

use App\Filament\Resources\JobApplications\JobApplicationResource;
use App\Models\JobApplication;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewJobApplication extends ViewRecord
{
    protected static string $resource = JobApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        /** @var JobApplication $jobApplication */
        $jobApplication = $this->getRecord();
        $jobApplication->loadMissing([
            'firstPriorityJobListing:id,job_code,title',
            'secondPriorityJobListing:id,job_code,title',
            'thirdPriorityJobListing:id,job_code,title',
        ]);

        $data['job_priority_1'] = $jobApplication->firstPriorityJobTitle();
        $data['job_priority_2'] = $jobApplication->secondPriorityJobTitle();
        $data['job_priority_3'] = $jobApplication->thirdPriorityJobTitle();

        return $data;
    }
}
