<?php

use App\Enums\DataRightsRequestStatus;
use App\Mail\DataRightsRequestReceived;
use App\Models\DataRightsRequest;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

use function Pest\Laravel\post;

it('stores a data rights request and redirects back to the rights section', function () {
    Mail::fake();

    $response = post(route('privacy-rights.store'), [
        'request_type' => 'الوصول والعلم',
        'email' => 'candidate@example.com',
        'details' => 'Please send a copy of my stored recruitment data.',
    ]);

    $response->assertRedirect()
        ->assertSessionHas('data_rights_success', true)
        ->assertSessionHas('data_rights_reference');

    $rightsRequest = DataRightsRequest::first();

    expect($rightsRequest)
        ->not->toBeNull()
        ->request_type->toBe('الوصول والعلم')
        ->email->toBe('candidate@example.com')
        ->details->toBe('Please send a copy of my stored recruitment data.')
        ->status->toBe(DataRightsRequestStatus::New)
        ->reference_number->toStartWith('DR-'.now()->format('Ymd').'-');
});

it('requires a valid request type and email address', function (array $payload, string $field) {
    $response = post(route('privacy-rights.store'), $payload);

    $response->assertSessionHasErrors($field);

    expect(DataRightsRequest::count())->toBe(0);
})->with([
    'missing request type' => [
        ['email' => 'candidate@example.com'],
        'request_type',
    ],
    'invalid request type' => [
        ['request_type' => 'غير معروف', 'email' => 'candidate@example.com'],
        'request_type',
    ],
    'missing email' => [
        ['request_type' => 'الوصول والعلم'],
        'email',
    ],
    'invalid email' => [
        ['request_type' => 'الوصول والعلم', 'email' => 'not-an-email'],
        'email',
    ],
]);

it('queues notification email to configured privacy recipients', function () {
    Mail::fake();

    $settings = app(GeneralSettings::class);
    $settings->privacy_rights_recipients = [
        ['email' => 'privacy@example.com'],
        ['email' => 'legal@example.com'],
    ];
    $settings->save();

    post(route('privacy-rights.store'), [
        'request_type' => 'المحو',
        'email' => 'candidate@example.com',
        'details' => 'Please delete my data.',
    ]);

    Mail::assertQueued(DataRightsRequestReceived::class, ['privacy@example.com', 'legal@example.com']);
});

it('submits the public data rights form through livewire', function () {
    Mail::fake();

    Livewire::test('data-rights-request-form')
        ->set('request_type', 'سحب الموافقة')
        ->set('email', 'candidate@example.com')
        ->set('details', 'Stop processing my recruitment data.')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSet('request_type', '')
        ->assertSet('email', '')
        ->assertSet('details', '');

    $rightsRequest = DataRightsRequest::first();

    expect($rightsRequest)
        ->not->toBeNull()
        ->request_type->toBe('سحب الموافقة')
        ->email->toBe('candidate@example.com')
        ->details->toBe('Stop processing my recruitment data.')
        ->reference_number->toStartWith('DR-'.now()->format('Ymd').'-');
});
