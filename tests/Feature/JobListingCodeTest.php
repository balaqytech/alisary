<?php

use App\Enums\JobLevel;
use App\Models\Company;
use App\Models\JobFamily;
use App\Models\JobListing;

it('generates an immutable job reference code when a vacancy is created', function () {
    $company = Company::factory()->create(['reference_code' => 'SCH']);
    $jobFamily = JobFamily::factory()->create(['code' => 'TEA']);

    $listing = JobListing::factory()
        ->for($company)
        ->for($jobFamily, 'jobFamily')
        ->create(['job_level' => JobLevel::L4]);

    expect($listing->job_code)->toBe('AEG-SCH-TEA-L4-'.now()->year.'-001')
        ->and($listing->job_code_year)->toBe(now()->year)
        ->and($listing->job_code_sequence)->toBe(1);

    $listing->update([
        'title' => 'Updated title',
        'job_code' => 'AEG-BAD-BAD-L1-1999-999',
        'job_code_year' => 1999,
        'job_code_sequence' => 999,
    ]);

    $listing->refresh();

    expect($listing->title)->toBe('Updated title')
        ->and($listing->job_code)->toBe('AEG-SCH-TEA-L4-'.now()->year.'-001')
        ->and($listing->job_code_year)->toBe(now()->year)
        ->and($listing->job_code_sequence)->toBe(1);
});

it('increments sequences inside the same reference scope', function () {
    $company = Company::factory()->create(['reference_code' => 'SCH']);
    $jobFamily = JobFamily::factory()->create(['code' => 'TEA']);

    $firstListing = JobListing::factory()
        ->for($company)
        ->for($jobFamily, 'jobFamily')
        ->create(['job_level' => JobLevel::L4]);

    $secondListing = JobListing::factory()
        ->for($company)
        ->for($jobFamily, 'jobFamily')
        ->create(['job_level' => JobLevel::L4]);

    expect($firstListing->job_code)->toBe('AEG-SCH-TEA-L4-'.now()->year.'-001')
        ->and($secondListing->job_code)->toBe('AEG-SCH-TEA-L4-'.now()->year.'-002');
});

it('keeps separate sequences for different reference scopes', function () {
    $company = Company::factory()->create(['reference_code' => 'SCH']);
    $teaching = JobFamily::factory()->create(['code' => 'TEA']);
    $operations = JobFamily::factory()->create(['code' => 'OPS']);

    $teachingListing = JobListing::factory()
        ->for($company)
        ->for($teaching, 'jobFamily')
        ->create(['job_level' => JobLevel::L4]);

    $operationsListing = JobListing::factory()
        ->for($company)
        ->for($operations, 'jobFamily')
        ->create(['job_level' => JobLevel::L4]);

    expect($teachingListing->job_code)->toBe('AEG-SCH-TEA-L4-'.now()->year.'-001')
        ->and($operationsListing->job_code)->toBe('AEG-SCH-OPS-L4-'.now()->year.'-001');
});
