<?php

use App\Models\JobApplication;
use App\Models\JobListing;

test('job applications endpoint returns job titles instead of reference codes', function () {
    $firstJobListing = JobListing::factory()->create(['title' => 'الوظيفة الأولى']);
    $secondJobListing = JobListing::factory()->create(['title' => 'الوظيفة الثانية']);
    $thirdJobListing = JobListing::factory()->create(['title' => 'الوظيفة الثالثة']);

    $jobApplication = JobApplication::factory()->create([
        'job_priority_1' => $firstJobListing->job_code,
        'job_priority_2' => $secondJobListing->job_code,
        'job_priority_3' => $thirdJobListing->job_code,
    ]);

    $this->getJson('/api/job-applications')
        ->assertSuccessful()
        ->assertJsonCount(1)
        ->assertJsonPath('0.id', $jobApplication->id)
        ->assertJsonPath('0.job_priority_1', $firstJobListing->title)
        ->assertJsonPath('0.job_priority_2', $secondJobListing->title)
        ->assertJsonPath('0.job_priority_3', $thirdJobListing->title)
        ->assertJsonPath('0.company.id', $jobApplication->company_id)
        ->assertJsonMissingPaths([
            '0.first_priority_job_listing',
            '0.second_priority_job_listing',
            '0.third_priority_job_listing',
        ]);
});

test('job applications endpoint preserves legacy titles and unknown references', function () {
    JobApplication::factory()->create([
        'job_priority_1' => 'عنوان وظيفة قديم',
        'job_priority_2' => 'UNKNOWN-CODE',
        'job_priority_3' => null,
    ]);

    $this->getJson('/api/job-applications')
        ->assertSuccessful()
        ->assertJsonPath('0.job_priority_1', 'عنوان وظيفة قديم')
        ->assertJsonPath('0.job_priority_2', 'UNKNOWN-CODE')
        ->assertJsonPath('0.job_priority_3', null);
});
