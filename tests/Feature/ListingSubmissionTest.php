<?php

use App\Enums\CustomFieldType;
use App\Enums\ListingKind;
use App\Enums\ListingStatus;
use App\Models\Listing;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('visitor can submit a valid listing application with custom answers and files', function () {
    Storage::fake('public');

    $listing = Listing::factory()->create([
        'kind' => ListingKind::Job,
        'status' => ListingStatus::Published,
        'form_fields' => [
            ['key' => 'experience_years', 'label' => 'سنوات الخبرة', 'type' => CustomFieldType::Number->value, 'required' => true],
            ['key' => 'cv', 'label' => 'السيرة الذاتية', 'type' => CustomFieldType::File->value, 'required' => true, 'accepted_file_types' => ['pdf'], 'max_file_size_kb' => 2048],
        ],
    ]);

    $this->post(route('jobs.apply', $listing), [
        'name' => 'أحمد العيسري',
        'email' => 'ahmed@example.com',
        'phone' => '90000000',
        'answers' => [
            'experience_years' => 5,
        ],
        'files' => [
            'cv' => UploadedFile::fake()->create('cv.pdf', 250, 'application/pdf'),
        ],
    ])->assertRedirect();

    $submission = $listing->submissions()->first();

    expect($submission)->not->toBeNull()
        ->and($submission->answers['experience_years'])->toBe(5)
        ->and($submission->files)->toHaveKey('cv');

    Storage::disk('public')->assertExists($submission->files['cv']);
});

test('required custom fields are validated', function () {
    $listing = Listing::factory()->create([
        'kind' => ListingKind::Tender,
        'status' => ListingStatus::Published,
        'form_fields' => [
            ['key' => 'company_name', 'label' => 'اسم الشركة', 'type' => CustomFieldType::Text->value, 'required' => true],
        ],
    ]);

    $this->from(route('tenders.show', $listing))
        ->post(route('tenders.apply', $listing), [
            'name' => 'شركة اختبار',
            'email' => 'supplier@example.com',
        ])
        ->assertRedirect(route('tenders.show', $listing))
        ->assertSessionHasErrors('answers.company_name');
});

test('closed listings reject submissions', function () {
    $listing = Listing::factory()->closed()->create([
        'kind' => ListingKind::Job,
    ]);

    $this->post(route('jobs.apply', $listing), [
        'name' => 'أحمد',
        'email' => 'ahmed@example.com',
    ])->assertForbidden();
});
