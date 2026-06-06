<?php

use App\Filament\Pages\GeneralSettings as GeneralSettingsPage;
use App\Filament\Pages\HomepageSettings as HomepageSettingsPage;
use App\Filament\Resources\JobListings\JobListingResource;
use App\Filament\Resources\TenderListings\TenderListingResource;
use App\Models\User;

test('filament listing resources and settings pages load for authenticated users', function () {
    config(['app.env' => 'local']);

    $this->actingAs(User::factory()->create());

    $this->get(JobListingResource::getUrl('create'))->assertSuccessful();
    $this->get(TenderListingResource::getUrl('create'))->assertSuccessful();
    $this->get(GeneralSettingsPage::getUrl())->assertSuccessful();
    $this->get(HomepageSettingsPage::getUrl())->assertSuccessful();
});
