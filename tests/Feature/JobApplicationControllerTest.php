<?php

use App\Enums\JobApplicationStatus;
use App\Models\Company;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Mail;

it('stores a job application successfully and redirects back', function () {
    Mail::fake();

    $company = Company::factory()->create();

    $jobsPage = $this->get(route('jobs.index'))
        ->assertSuccessful()
        ->assertSee('data-job-application-form', false)
        ->assertSee('data-job-application-submit', false)
        ->assertDontSee('aria-disabled="true"', false);

    expect($jobsPage->getContent())
        ->not->toMatch('/<button\b(?=[^>]*\bdata-job-application-submit\b)(?=[^>]*\sdisabled(?:\s|=|\/?>))[^>]*>/');

    $response = $this->from(route('jobs.index'))->post(route('jobs.apply.unified'), [
        'full_name' => 'John Doe',
        'phone' => '123456789',
        'email' => 'john@example.com',
        'nationality' => 'Omani',
        'country' => 'Oman',
        'city' => 'Muscat',
        'company_id' => $company->id,
        'job_priority_1' => 'Software Engineer',
        'job_priority_2' => 'Web Developer',
        'job_priority_3' => 'Backend Developer',
        'contract_types' => ['دوام كامل', 'عمل حرّ مستقل (Freelance)'],
        'expected_salary' => '1000 OMR',
        'years_experience' => 5,
        'previously_worked' => 1,
        'previous_institution' => 'Al Aisary',
        'q_achievement' => 'Automated a manual reporting process, cutting turnaround from days to minutes.',
        'governorate' => '',
        'consent_accurate' => 1,
        'consent_ai' => 1,
        'consent_pool' => 1,
        'cv_link' => 'https://example.com/resume.pdf',
    ]);

    $response->assertRedirect(route('jobs.index').'#apply-form')
        ->assertSessionHas('application_success', true);

    $successPage = $this->get(route('jobs.index'))
        ->assertSuccessful()
        ->assertSee('aria-disabled="true"', false)
        ->assertSee('تم إرسال الطلب');

    expect($successPage->getContent())
        ->toMatch('/<button\b(?=[^>]*\bdata-job-application-submit\b)(?=[^>]*\sdisabled(?:\s|=|\/?>))[^>]*>/');

    $application = JobApplication::first();

    expect($application)
        ->not->toBeNull()
        ->full_name->toBe('John Doe')
        ->email->toBe('john@example.com')
        ->status->toBe(JobApplicationStatus::New)
        ->previously_worked->toBeTrue()
        ->consent_pool->toBeTrue()
        ->cv_link->toBe('https://example.com/resume.pdf')
        ->reference_number->not->toBeNull()
        ->contract_types->toBe(['دوام كامل', 'عمل حرّ مستقل (Freelance)']);

    // If Settings returns emails in testing, it will queue.
    // In tests, the database settings might be empty by default,
    // so we can just assert nothing broke, or mock Settings if needed.
});

it('rejects a second application to the same job with the same email', function () {
    Mail::fake();

    $company = Company::factory()->create();

    $payload = [
        'full_name' => 'John Doe',
        'phone' => '123456789',
        'email' => 'john@example.com',
        'company_id' => $company->id,
        'job_priority_1' => 'Software Engineer',
        'contract_types' => ['Full time'],
        'expected_salary' => '1000 OMR',
        'q_achievement' => 'Automated a manual reporting process, cutting turnaround from days to minutes.',
        'governorate' => '',
        'consent_accurate' => 1,
        'consent_ai' => 1,
    ];

    $this->from(route('jobs.index'))->post(route('jobs.apply.unified'), $payload)
        ->assertRedirect(route('jobs.index').'#apply-form');

    expect(JobApplication::query()->count())->toBe(1);

    $this->from(route('jobs.index'))->post(route('jobs.apply.unified'), $payload)
        ->assertSessionHasErrors('email');

    expect(JobApplication::query()->count())->toBe(1);
});

it('allows the same email to apply to a different job', function () {
    Mail::fake();

    $company = Company::factory()->create();

    $basePayload = [
        'full_name' => 'John Doe',
        'phone' => '123456789',
        'email' => 'john@example.com',
        'company_id' => $company->id,
        'contract_types' => ['Full time'],
        'expected_salary' => '1000 OMR',
        'q_achievement' => 'Automated a manual reporting process, cutting turnaround from days to minutes.',
        'governorate' => '',
        'consent_accurate' => 1,
        'consent_ai' => 1,
    ];

    $this->from(route('jobs.index'))
        ->post(route('jobs.apply.unified'), [...$basePayload, 'job_priority_1' => 'Software Engineer'])
        ->assertRedirect(route('jobs.index').'#apply-form');

    $this->from(route('jobs.index'))
        ->post(route('jobs.apply.unified'), [...$basePayload, 'job_priority_1' => 'Product Manager'])
        ->assertRedirect(route('jobs.index').'#apply-form');

    expect(JobApplication::query()->count())->toBe(2);
});

it('stores a long tools_and_ai answer without truncating it', function () {
    Mail::fake();

    $company = Company::factory()->create();
    $toolsAndAi = str_repeat('Worked on educational and administrative projects. ', 80);

    $this->from(route('jobs.index'))->post(route('jobs.apply.unified'), [
        'full_name' => 'John Doe',
        'phone' => '123456789',
        'email' => 'john@example.com',
        'company_id' => $company->id,
        'job_priority_1' => 'Software Engineer',
        'contract_types' => ['Full time'],
        'expected_salary' => '1000 OMR',
        'q_achievement' => 'Automated a manual reporting process, cutting turnaround from days to minutes.',
        'governorate' => '',
        'tools_and_ai' => $toolsAndAi,
        'consent_accurate' => 1,
        'consent_ai' => 1,
    ])->assertRedirect(route('jobs.index').'#apply-form');

    expect(JobApplication::query()->firstOrFail()->tools_and_ai)
        ->toBe(rtrim($toolsAndAi));
});
