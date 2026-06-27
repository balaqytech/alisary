<?php

use App\Enums\JobApplicationStatus;
use App\Models\Company;
use App\Models\JobApplication;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\post;

it('stores a job application successfully and redirects back', function () {
    Storage::fake('public');

    $company = Company::factory()->create();

    $response = post(route('jobs.apply.unified'), [
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
        'previously_worked_where' => 'Al Aisary',
        'q_automate' => 'Automated deployment',
        'q_learn' => 'Learned Laravel',
        'q_own' => 'Built a CRM',
        'q_brand' => 'I would refuse',
        'q_ethics' => 'I would choose ethics',
        'q_mission' => 'Preparing for a good life',
        'consent_accurate' => 1,
        'consent_ai' => 1,
        'consent_pool' => 1,
        'cv' => UploadedFile::fake()->create('resume.pdf', 100, 'application/pdf'),
    ]);

    $response->assertRedirect()
        ->assertSessionHas('application_success', true);

    $application = JobApplication::first();

    expect($application)
        ->not->toBeNull()
        ->full_name->toBe('John Doe')
        ->email->toBe('john@example.com')
        ->status->toBe(JobApplicationStatus::New)
        ->previously_worked->toBeTrue()
        ->consent_pool->toBeTrue()
        ->cv_path->not->toBeNull()
        ->reference_number->not->toBeNull()
        ->contract_types->toBe(['دوام كامل', 'عمل حرّ مستقل (Freelance)']);

    Storage::disk('public')->assertExists($application->cv_path);
});
