<?php

use App\Enums\JobApplicationStatus;
use App\Enums\JobTrack;
use App\Models\Company;
use App\Models\JobApplication;
use App\Models\JobFamily;
use App\Models\JobListing;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

function jobApplicationListing(Company $company): JobListing
{
    $jobFamily = JobFamily::factory()->create(['track' => JobTrack::Teach]);

    return JobListing::factory()
        ->for($company)
        ->for($jobFamily)
        ->create(['title' => 'Software Engineer']);
}

/**
 * @param  array<string, mixed>  $overrides
 * @return array<string, mixed>
 */
function validJobApplicationPayload(Company $company, JobListing $jobListing, array $overrides = []): array
{
    return array_replace([
        'submission_token' => (string) Str::uuid(),
        'full_name' => 'John Doe',
        'phone_country_code' => '+968',
        'phone' => '91234567',
        'email' => 'john@example.com',
        'gender' => 'male',
        'nationality' => 'Omani',
        'country' => 'Oman',
        'city' => 'Muscat',
        'company_id' => $company->id,
        'job_priority_1' => $jobListing->job_code,
        'contract_types' => ['دوام كامل'],
        'expected_salary' => 1000,
        'years_experience' => 5,
        'previously_worked' => 1,
        'previous_institution' => 'Al Aisary',
        'q_achievement' => 'I improved a measurable process from ten hours to two hours.',
        'q_sample_teaching' => 'I would assess the learner, adapt the activity, and measure reading fluency.',
        'q_compelling_reason' => 'I combine relevant experience with measurable ownership and fast learning.',
        'consent_accurate' => 1,
        'consent_ai' => 1,
        'consent_pool' => 1,
    ], $overrides);
}

it('stores a job application, shows its reference number, and locks the submit button', function () {
    Mail::fake();

    $company = Company::factory()->create();
    $jobListing = jobApplicationListing($company);

    $jobsPage = $this->get(route('jobs.index'))
        ->assertSuccessful()
        ->assertSee('data-job-application-form', false)
        ->assertSee('data-job-application-submit', false)
        ->assertSee('value="+968" selected', false)
        ->assertDontSee('aria-disabled="true"', false);

    expect($jobsPage->getContent())
        ->not->toMatch('/<button\b(?=[^>]*\bdata-job-application-submit\b)(?=[^>]*\sdisabled(?:\s|=|\/?>))[^>]*>/');

    $response = $this->from(route('jobs.index'))->post(
        route('jobs.apply.unified'),
        validJobApplicationPayload($company, $jobListing),
    );

    $application = JobApplication::query()->firstOrFail();

    $response->assertRedirect(route('jobs.index').'#apply-form')
        ->assertSessionHas('application_success', true)
        ->assertSessionHas('application_reference_number', $application->reference_number);

    $successPage = $this->get(route('jobs.index'))
        ->assertSuccessful()
        ->assertSee('aria-disabled="true"', false)
        ->assertSee('تم إرسال الطلب')
        ->assertSee($application->reference_number);

    expect($successPage->getContent())
        ->toMatch('/<button\b(?=[^>]*\bdata-job-application-submit\b)(?=[^>]*\sdisabled(?:\s|=|\/?>))[^>]*>/');

    expect($application)
        ->full_name->toBe('John Doe')
        ->phone_country_code->toBe('+968')
        ->phone->toBe('91234567')
        ->email->toBe('john@example.com')
        ->gender->toBe('male')
        ->status->toBe(JobApplicationStatus::New)
        ->previously_worked->toBeTrue()
        ->consent_pool->toBeTrue()
        ->reference_number->not->toBeNull()
        ->contract_types->toBe(['دوام كامل'])
        ->q_compelling_reason->not->toBeEmpty();
});

it('rejects a second application to the same job with the same email', function () {
    Mail::fake();

    $company = Company::factory()->create();
    $jobListing = jobApplicationListing($company);
    $payload = validJobApplicationPayload($company, $jobListing);

    $this->from(route('jobs.index'))->post(route('jobs.apply.unified'), $payload)
        ->assertRedirect(route('jobs.index').'#apply-form');

    expect(JobApplication::query()->count())->toBe(1);

    $this->from(route('jobs.index'))->post(route('jobs.apply.unified'), [
        ...$payload,
        'submission_token' => (string) Str::uuid(),
    ])
        ->assertSessionHasErrors('email');

    expect(JobApplication::query()->count())->toBe(1);
});

it('allows the same email to apply to a different job', function () {
    Mail::fake();

    $company = Company::factory()->create();
    $firstJobListing = jobApplicationListing($company);
    $secondJobListing = jobApplicationListing($company);

    $this->from(route('jobs.index'))
        ->post(route('jobs.apply.unified'), validJobApplicationPayload($company, $firstJobListing))
        ->assertRedirect(route('jobs.index').'#apply-form');

    $this->from(route('jobs.index'))
        ->post(route('jobs.apply.unified'), validJobApplicationPayload($company, $secondJobListing))
        ->assertRedirect(route('jobs.index').'#apply-form');

    expect(JobApplication::query()->count())->toBe(2);
});

it('stores a long tools_and_ai answer without truncating it', function () {
    Mail::fake();

    $company = Company::factory()->create();
    $jobListing = jobApplicationListing($company);
    $toolsAndAi = str_repeat('Worked with automation and artificial intelligence tools. ', 80);

    $this->from(route('jobs.index'))->post(route('jobs.apply.unified'), validJobApplicationPayload(
        $company,
        $jobListing,
        ['tools_and_ai' => $toolsAndAi],
    ))->assertRedirect(route('jobs.index').'#apply-form');

    expect(JobApplication::query()->firstOrFail()->tools_and_ai)
        ->toBe(rtrim($toolsAndAi));
});

it('validates contact, numeric, gender, and pivotal question fields', function (string $field, mixed $invalidValue) {
    Mail::fake();

    $company = Company::factory()->create();
    $jobListing = jobApplicationListing($company);

    $this->from(route('jobs.index'))
        ->post(route('jobs.apply.unified'), validJobApplicationPayload($company, $jobListing, [
            $field => $invalidValue,
        ]))
        ->assertRedirect(route('jobs.index').'#apply-form')
        ->assertSessionHasErrors($field);

    expect(JobApplication::query()->count())->toBe(0);
})->with([
    'invalid email' => ['email', 'not-an-email'],
    'non-numeric expected salary' => ['expected_salary', '1000 OMR'],
    'non-numeric experience years' => ['years_experience', 'five'],
    'missing gender' => ['gender', null],
    'missing achievement answer' => ['q_achievement', null],
    'missing track-specific answer' => ['q_sample_teaching', null],
    'missing compelling reason' => ['q_compelling_reason', null],
]);

it('renders a validation summary and messages beside every invalid field', function () {
    Mail::fake();

    $company = Company::factory()->create();
    $jobListing = jobApplicationListing($company);

    $response = $this->from(route('jobs.index'))->post(
        route('jobs.apply.unified'),
        validJobApplicationPayload($company, $jobListing, [
            'country' => str_repeat('a', 101),
            'ready_date' => 'not-a-date',
            'previous_role' => str_repeat('a', 256),
            'consent_accurate' => null,
            'consent_ai' => null,
        ]),
    );

    $response->assertRedirect(route('jobs.index').'#apply-form');

    $page = $this->followRedirects($response);

    $page
        ->assertSuccessful()
        ->assertSee('data-validation-summary', false)
        ->assertSee('تعذّر إرسال الطلب. يرجى مراجعة الحقول التالية:')
        ->assertSee('data-validation-error-for="country"', false)
        ->assertSee('data-validation-error-for="ready_date"', false)
        ->assertSee('data-validation-error-for="previous_role"', false)
        ->assertSee('data-validation-error-for="consent_accurate"', false)
        ->assertSee('data-validation-error-for="consent_ai"', false);
});

it('uses Oman as the default phone country code', function () {
    Mail::fake();

    $company = Company::factory()->create();
    $jobListing = jobApplicationListing($company);
    $payload = validJobApplicationPayload($company, $jobListing);
    unset($payload['phone_country_code']);

    $this->post(route('jobs.apply.unified'), $payload)->assertRedirect();

    expect(JobApplication::query()->firstOrFail()->phone_country_code)->toBe('+968');
});

it('does not create a duplicate application for the same submission token', function () {
    Mail::fake();

    $company = Company::factory()->create();
    $jobListing = jobApplicationListing($company);
    $payload = validJobApplicationPayload($company, $jobListing);

    $firstResponse = $this->post(route('jobs.apply.unified'), $payload)->assertRedirect();
    $secondResponse = $this->post(route('jobs.apply.unified'), $payload)->assertRedirect();
    $application = JobApplication::query()->sole();

    $firstResponse->assertSessionHas('application_reference_number', $application->reference_number);
    $secondResponse->assertSessionHas('application_reference_number', $application->reference_number);
    expect(JobApplication::query()->count())->toBe(1);
});
