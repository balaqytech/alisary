<?php

use App\Models\JobApplication;
use App\Models\JobListing;

test('job applications endpoint returns only current table columns', function () {
    $firstJobListing = JobListing::factory()->create(['title' => 'الوظيفة الأولى']);
    $secondJobListing = JobListing::factory()->create(['title' => 'الوظيفة الثانية']);
    $thirdJobListing = JobListing::factory()->create(['title' => 'الوظيفة الثالثة']);

    $jobApplication = JobApplication::factory()->create([
        'job_priority_1' => $firstJobListing->job_code,
        'job_priority_2' => $secondJobListing->job_code,
        'job_priority_3' => $thirdJobListing->job_code,
        'cv_link' => 'https://example.com/cv',
        'cv_path' => 'job-applications/cv.pdf',
    ]);

    $response = $this->getJson('/api/job-applications')
        ->assertSuccessful()
        ->assertJsonCount(1)
        ->assertJsonPath('0.job_priority_1', $firstJobListing->title)
        ->assertJsonPath('0.cv_link', 'https://example.com/cv')
        ->assertJsonPath('0.company_id', $jobApplication->company_id)
        ->assertJsonPath('0.company.id', $jobApplication->company_id)
        ->assertJsonPath('0.company.name', $jobApplication->company->name)
        ->assertJsonMissingPaths([
            '0.id',
            '0.phone_country_code',
            '0.updated_at',
            '0.job_priority_2',
            '0.job_priority_3',
            '0.previously_worked_where',
            '0.cv_path',
            '0.q_automate',
            '0.q_learn',
            '0.q_own',
            '0.q_brand',
            '0.q_ethics',
            '0.q_mission',
            '0.future_aspirations',
            '0.q_build',
            '0.extra_notes',
            '0.consent_transfer',
            '0.form_version',
            '0.first_priority_job_listing',
            '0.second_priority_job_listing',
            '0.third_priority_job_listing',
        ]);

    expect(array_keys($response->json('0')))->toBe([
        'reference_number',
        'status',
        'full_name',
        'phone',
        'email',
        'gender',
        'nationality',
        'country',
        'city',
        'company_id',
        'company',
        'governorate',
        'branch',
        'job_priority_1',
        'track',
        'contract_types',
        'ready_date',
        'expected_salary',
        'years_experience',
        'previously_worked',
        'previous_institution',
        'previous_role',
        'previous_period',
        'tools_and_ai',
        'cv_link',
        'q_achievement',
        'q_sample_teaching',
        'q_sample_operations',
        'q_sample_leadership',
        'q_compelling_reason',
        'consent_accurate',
        'consent_ai',
        'consent_pool',
        'internal_notes',
        'created_at',
    ]);
});

test('job applications endpoint preserves legacy primary job titles and unknown references', function () {
    JobApplication::factory()->create([
        'job_priority_1' => 'عنوان وظيفة قديم',
        'job_priority_2' => 'UNKNOWN-CODE',
        'job_priority_3' => null,
    ]);

    $this->getJson('/api/job-applications')
        ->assertSuccessful()
        ->assertJsonPath('0.job_priority_1', 'عنوان وظيفة قديم')
        ->assertJsonMissingPaths(['0.job_priority_2', '0.job_priority_3']);
});

test('job applications endpoint returns an absolute URL for an uploaded CV', function () {
    config(['filesystems.disks.public.url' => 'https://careers.example.com/storage']);

    JobApplication::factory()->create([
        'cv_link' => null,
        'cv_path' => 'job-applications/cvs/candidate.pdf',
    ]);

    $this->getJson('/api/job-applications')
        ->assertSuccessful()
        ->assertJsonPath('0.cv_link', 'https://careers.example.com/storage/job-applications/cvs/candidate.pdf')
        ->assertJsonMissingPath('0.cv_path');
});
