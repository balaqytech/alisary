<?php

use App\Enums\CustomFieldType;
use App\Enums\ListingStatus;
use App\Models\JobListing;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('visitor can submit a valid job application with default fields, cv, and custom fields', function () {
    Storage::fake('public');

    $jobListing = JobListing::factory()->create([
        'form_fields' => [
            ['key' => 'experience_years', 'label' => 'سنوات الخبرة', 'type' => CustomFieldType::Number->value, 'required' => true],
            ['key' => 'portfolio', 'label' => 'ملف إضافي', 'type' => CustomFieldType::File->value, 'required' => true, 'accepted_file_types' => ['pdf'], 'max_file_size_kb' => 2048],
        ],
    ]);

    $this->post(route('jobs.apply', $jobListing), [
        'full_name' => 'أحمد العيسري',
        'phone' => '90000000',
        'email' => 'ahmed@example.com',
        'birthday' => '1995-01-01',
        'cv' => UploadedFile::fake()->create('cv.pdf', 250, 'application/pdf'),
        'answers' => [
            'experience_years' => 5,
        ],
        'files' => [
            'portfolio' => UploadedFile::fake()->create('portfolio.pdf', 250, 'application/pdf'),
        ],
    ])->assertRedirect();

    $submission = $jobListing->submissions()->first();

    expect($submission)->not->toBeNull()
        ->and($submission->full_name)->toBe('أحمد العيسري')
        ->and($submission->email)->toBe('ahmed@example.com')
        ->and($submission->phone)->toBe('90000000')
        ->and($submission->birthday->toDateString())->toBe('1995-01-01')
        ->and((int) $submission->answers['experience_years'])->toBe(5)
        ->and($submission->files)->toHaveKey('portfolio')
        ->and($submission->submittable->is($jobListing))->toBeTrue();

    Storage::disk('public')->assertExists($submission->cv_path);
    Storage::disk('public')->assertExists($submission->files['portfolio']);
});

test('required job custom fields are validated', function () {
    $jobListing = JobListing::factory()->create([
        'form_fields' => [
            ['key' => 'experience_years', 'label' => 'سنوات الخبرة', 'type' => CustomFieldType::Number->value, 'required' => true],
        ],
    ]);

    $this->from(route('jobs.show', $jobListing))
        ->post(route('jobs.apply', $jobListing), [
            'full_name' => 'أحمد',
            'phone' => '90000000',
            'email' => 'ahmed@example.com',
            'birthday' => '1995-01-01',
            'cv' => UploadedFile::fake()->create('cv.pdf', 250, 'application/pdf'),
        ])
        ->assertRedirect(route('jobs.show', $jobListing))
        ->assertSessionHasErrors('answers.experience_years');
});

test('closed jobs reject submissions', function () {
    $jobListing = JobListing::factory()->create([
        'status' => ListingStatus::Closed,
    ]);

    $this->post(route('jobs.apply', $jobListing), [
        'full_name' => 'أحمد',
        'phone' => '90000000',
        'email' => 'ahmed@example.com',
        'birthday' => '1995-01-01',
        'cv' => UploadedFile::fake()->create('cv.pdf', 250, 'application/pdf'),
    ])->assertForbidden();
});
