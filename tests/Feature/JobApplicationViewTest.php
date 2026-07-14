<?php

use App\Filament\Resources\JobApplications\Pages\ViewJobApplication;
use App\Models\JobApplication;
use App\Models\JobListing;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

test('job application view shows job titles instead of reference codes', function () {
    $firstJobListing = JobListing::factory()->create(['title' => 'الوظيفة الأولى']);
    $secondJobListing = JobListing::factory()->create(['title' => 'الوظيفة الثانية']);
    $thirdJobListing = JobListing::factory()->create(['title' => 'الوظيفة الثالثة']);

    $jobApplication = JobApplication::factory()->create([
        'job_priority_1' => $firstJobListing->job_code,
        'job_priority_2' => $secondJobListing->job_code,
        'job_priority_3' => $thirdJobListing->job_code,
    ]);

    Livewire::test(ViewJobApplication::class, ['record' => $jobApplication->getRouteKey()])
        ->assertSchemaStateSet([
            'job_priority_1' => $firstJobListing->title,
            'job_priority_2' => $secondJobListing->title,
            'job_priority_3' => $thirdJobListing->title,
        ], 'form');

    $jobApplication->refresh();

    expect($jobApplication->job_priority_1)->toBe($firstJobListing->job_code)
        ->and($jobApplication->job_priority_2)->toBe($secondJobListing->job_code)
        ->and($jobApplication->job_priority_3)->toBe($thirdJobListing->job_code);
});
