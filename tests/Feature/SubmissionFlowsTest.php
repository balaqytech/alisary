<?php

use App\Enums\CustomFieldType;
use App\Enums\ListingStatus;
use App\Models\TenderListing;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('visitor can submit a valid tender wizard application with step answers and files', function () {
    Storage::fake('public');

    $tenderListing = TenderListing::factory()->create([
        'form_steps' => [
            [
                'title' => 'بيانات الشركة',
                'fields' => [
                    ['key' => 'company_name', 'label' => 'اسم الشركة', 'type' => CustomFieldType::Text->value, 'required' => true],
                    ['key' => 'commercial_registration', 'label' => 'السجل التجاري', 'type' => CustomFieldType::File->value, 'required' => true, 'accepted_file_types' => ['pdf'], 'max_file_size_kb' => 2048],
                ],
            ],
            [
                'title' => 'العرض',
                'fields' => [
                    ['key' => 'offer_value', 'label' => 'قيمة العرض', 'type' => CustomFieldType::Number->value, 'required' => true],
                ],
            ],
        ],
    ]);

    $this->post(route('tenders.apply', $tenderListing), [
        'full_name' => 'شركة اختبار',
        'phone' => '91111111',
        'email' => 'supplier@example.com',
        'answers' => [
            'company_name' => 'شركة اختبار',
            'offer_value' => 1200,
        ],
        'files' => [
            'commercial_registration' => UploadedFile::fake()->create('cr.pdf', 250, 'application/pdf'),
        ],
    ])->assertRedirect();

    $submission = $tenderListing->submissions()->first();

    expect($submission)->not->toBeNull()
        ->and($submission->full_name)->toBe('شركة اختبار')
        ->and($submission->answers['company_name'])->toBe('شركة اختبار')
        ->and((int) $submission->answers['offer_value'])->toBe(1200)
        ->and($submission->files)->toHaveKey('commercial_registration')
        ->and($submission->submittable->is($tenderListing))->toBeTrue();

    Storage::disk('public')->assertExists($submission->files['commercial_registration']);
});

test('closed tenders reject submissions', function () {
    $tenderListing = TenderListing::factory()->create([
        'status' => ListingStatus::Closed,
    ]);

    $this->post(route('tenders.apply', $tenderListing), [
        'full_name' => 'شركة اختبار',
        'phone' => '91111111',
        'email' => 'supplier@example.com',
    ])->assertForbidden();
});
