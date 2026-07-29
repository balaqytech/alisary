<?php

use App\Filament\Pages\GeneralSettings as GeneralSettingsPage;
use App\Filament\Pages\HomepageSettings as HomepageSettingsPage;
use App\Filament\Resources\JobListings\JobListingResource;
use App\Filament\Resources\TenderListings\TenderListingResource;
use App\Models\User;
use Filament\Panel;

test('filament listing resources and settings pages load for authenticated users', function () {
    config(['app.env' => 'local']);

    $this->actingAs(User::factory()->create());

    $this->get(JobListingResource::getUrl('create'))->assertSuccessful();
    $this->get(TenderListingResource::getUrl('create'))->assertSuccessful();
    $this->get(GeneralSettingsPage::getUrl())->assertSuccessful();
    $this->get(HomepageSettingsPage::getUrl())->assertSuccessful();
});

test('authenticated users can access the admin panel in production', function () {
    config(['app.env' => 'production']);

    $this->actingAs(User::factory()->create());

    $this->get(JobListingResource::getUrl())->assertSuccessful();
});

test('users are authorized only for the admin panel', function () {
    $user = User::factory()->create();

    expect($user->canAccessPanel(Panel::make()->id('admin')))->toBeTrue()
        ->and($user->canAccessPanel(Panel::make()->id('other')))->toBeFalse();
});
