<?php

use App\Enums\CustomFieldType;
use App\Enums\ListingStatus;
use App\Mail\TenderSubmissionReceived;
use App\Models\TenderListing;
use App\Settings\GeneralSettings;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
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

test('tender submissions queue notifications to configured internal recipients', function () {
    Storage::fake('public');
    Mail::fake();

    $settings = app(GeneralSettings::class);
    $settings->job_submission_recipients = [];
    $settings->tender_submission_recipients = [
        ['email' => 'procurement@example.com'],
        ['email' => 'tenders@example.com'],
    ];
    $settings->save();

    $tenderListing = TenderListing::factory()->create([
        'title' => 'Supply Tender',
        'form_steps' => [
            [
                'title' => 'Company',
                'fields' => [
                    ['key' => 'commercial_registration', 'label' => 'CR', 'type' => CustomFieldType::File->value, 'required' => true, 'accepted_file_types' => ['pdf']],
                ],
            ],
        ],
    ]);

    $this->post(route('tenders.apply', $tenderListing), [
        'full_name' => 'Supplier Company',
        'phone' => '91111111',
        'email' => 'supplier@example.com',
        'files' => [
            'commercial_registration' => UploadedFile::fake()->create('cr.pdf', 250, 'application/pdf'),
        ],
    ])->assertRedirect();

    $submission = $tenderListing->submissions()->first();

    Mail::assertQueued(TenderSubmissionReceived::class, function (TenderSubmissionReceived $mail) use ($tenderListing, $submission): bool {
        return $mail->hasTo(['procurement@example.com', 'tenders@example.com'])
            && $mail->tenderListing->is($tenderListing)
            && $mail->submission->is($submission);
    });
});

test('tender submissions do not queue notifications without configured recipients', function () {
    Storage::fake('public');
    Mail::fake();

    $settings = app(GeneralSettings::class);
    $settings->job_submission_recipients = [];
    $settings->tender_submission_recipients = [];
    $settings->save();

    $tenderListing = TenderListing::factory()->create();

    $this->post(route('tenders.apply', $tenderListing), [
        'full_name' => 'Supplier Company',
        'phone' => '91111111',
        'email' => 'supplier@example.com',
    ])->assertRedirect();

    Mail::assertNothingOutgoing();
});

test('tender submission email renders basic details without file references', function () {
    $tenderListing = TenderListing::factory()->create(['title' => 'Supply Tender'])->load('contractor');
    $submission = $tenderListing->submissions()->create([
        'full_name' => 'Supplier Company',
        'phone' => '91111111',
        'email' => 'supplier@example.com',
        'answers' => [],
        'files' => ['commercial_registration' => 'submissions/tenders/1/files/cr.pdf'],
    ]);

    $mailable = new TenderSubmissionReceived($tenderListing, $submission);

    $mailable
        ->assertSeeInHtml('Supply Tender')
        ->assertSeeInHtml('طلب تقديم على مناقصة')
        ->assertSeeInHtml('Supplier Company')
        ->assertSeeInHtml('supplier@example.com')
        ->assertSeeInHtml('91111111')
        ->assertSeeInHtml('logo.svg')
        ->assertDontSeeInHtml('laravel.com/img/notification-logo')
        ->assertDontSeeInHtml('submissions/tenders/1/files/cr.pdf');
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
