<?php

use App\Filament\Resources\JobApplications\Pages\ListJobApplications;
use App\Filament\Resources\JobListings\JobListingResource;
use App\Filament\Resources\JobListings\Pages\EditJobListing;
use App\Filament\Resources\JobListings\RelationManagers\JobApplicationsRelationManager;
use App\Filament\Resources\Submissions\Pages\ListSubmissions;
use App\Models\JobApplication;
use App\Models\JobListing;
use App\Models\User;
use Livewire\Livewire;

use function Livewire\invade;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

function jobApplicationTableColumns(): array
{
    return [
        'reference_number',
        'status',
        'full_name',
        'phone',
        'email',
        'nationality',
        'country',
        'city',
        'company.name',
        'branch',
        'job_priority_1',
        'job_priority_2',
        'job_priority_3',
        'contract_types',
        'ready_date',
        'expected_salary',
        'years_experience',
        'previously_worked',
        'previously_worked_where',
        'tools_and_ai',
        'cv_link',
        'cv_path',
        'q_automate',
        'q_learn',
        'q_own',
        'q_brand',
        'q_ethics',
        'q_mission',
        'future_aspirations',
        'q_build',
        'extra_notes',
        'consent_accurate',
        'consent_ai',
        'consent_pool',
        'consent_transfer',
        'internal_notes',
        'created_at',
    ];
}

test('submission and job application tables expose excel export actions', function () {
    Livewire::test(ListSubmissions::class)
        ->assertTableActionExists('export')
        ->assertTableBulkActionExists('export');

    Livewire::test(ListJobApplications::class)
        ->assertTableActionExists('export')
        ->assertTableBulkActionExists('export');
});

test('job application excel export contains every application table column', function () {
    $fullAnswer = str_repeat('إجابة تفصيلية ', 10);
    $firstJobListing = JobListing::factory()->create(['title' => 'الوظيفة الأولى']);
    $secondJobListing = JobListing::factory()->create(['title' => 'الوظيفة الثانية']);
    $thirdJobListing = JobListing::factory()->create(['title' => 'الوظيفة الثالثة']);
    $jobApplication = JobApplication::factory()->create([
        'job_priority_1' => $firstJobListing->job_code,
        'job_priority_2' => $secondJobListing->job_code,
        'job_priority_3' => $thirdJobListing->job_code,
        'q_automate' => $fullAnswer,
        'consent_pool' => true,
    ]);

    $columns = jobApplicationTableColumns();

    $component = Livewire::test(ListJobApplications::class);

    foreach ($columns as $column) {
        $component->assertTableColumnExists($column);
    }

    $component
        ->assertTableColumnFormattedStateSet('job_priority_1', $firstJobListing->title, $jobApplication)
        ->assertTableColumnFormattedStateSet('job_priority_2', $secondJobListing->title, $jobApplication)
        ->assertTableColumnFormattedStateSet('job_priority_3', $thirdJobListing->title, $jobApplication);

    $exportAction = $component->instance()->getTable()->getAction('export');
    $export = invade($exportAction)->exports->first()->hydrate($component->instance());
    $mappedApplication = $export->map($export->getQuery()->findOrFail($jobApplication->id));

    expect(array_keys($export->getColumns()))->toBe($columns)
        ->and($mappedApplication['job_priority_1'])->toBe($firstJobListing->title)
        ->and($mappedApplication['job_priority_2'])->toBe($secondJobListing->title)
        ->and($mappedApplication['job_priority_3'])->toBe($thirdJobListing->title)
        ->and($mappedApplication['q_automate'])->toBe($fullAnswer)
        ->and($mappedApplication['consent_pool'])->toBe('نعم');
});

test('job listing relation manager scopes job applications across all priorities and exports every column', function () {
    $jobListing = JobListing::factory()->create();
    $jobReference = $jobListing->job_code;

    $primaryApplication = JobApplication::factory()->create([
        'job_priority_1' => $jobReference,
    ]);
    $secondaryApplication = JobApplication::factory()->create([
        'job_priority_1' => 'another-job',
        'job_priority_2' => $jobReference,
    ]);
    $tertiaryApplication = JobApplication::factory()->create([
        'job_priority_1' => 'another-job',
        'job_priority_3' => $jobReference,
    ]);
    $legacyApplication = JobApplication::factory()->create([
        'job_priority_1' => $jobListing->title,
    ]);
    $unrelatedApplication = JobApplication::factory()->create([
        'job_priority_1' => 'unrelated-job',
    ]);

    $component = Livewire::test(JobApplicationsRelationManager::class, [
        'ownerRecord' => $jobListing,
        'pageClass' => EditJobListing::class,
    ]);

    $component
        ->assertCanSeeTableRecords([
            $primaryApplication,
            $secondaryApplication,
            $tertiaryApplication,
            $legacyApplication,
        ])
        ->assertCanNotSeeTableRecords([$unrelatedApplication])
        ->assertTableColumnFormattedStateSet('job_priority_1', $jobListing->title, $primaryApplication)
        ->assertTableColumnFormattedStateSet('job_priority_2', $jobListing->title, $secondaryApplication)
        ->assertTableColumnFormattedStateSet('job_priority_3', $jobListing->title, $tertiaryApplication)
        ->assertTableColumnFormattedStateSet('job_priority_1', $jobListing->title, $legacyApplication)
        ->assertTableActionExists('export')
        ->assertTableBulkActionExists('export');

    $relationColumns = array_keys($component->instance()->getTable()->getColumns());

    $exportAction = $component->instance()->getTable()->getAction('export');
    $export = invade($exportAction)->exports->first()->hydrate($component->instance());
    $exportedApplications = $export->getQuery()->get()->keyBy('id');
    $exportedIds = $exportedApplications->keys()->sort()->values()->all();

    expect(JobListingResource::getRelations())->toBe([JobApplicationsRelationManager::class])
        ->and($relationColumns)->toBe(jobApplicationTableColumns())
        ->and($exportedIds)->toBe(collect([
            $primaryApplication->id,
            $secondaryApplication->id,
            $tertiaryApplication->id,
            $legacyApplication->id,
        ])->sort()->values()->all())
        ->and($export->map($exportedApplications->get($primaryApplication->id))['job_priority_1'])->toBe($jobListing->title)
        ->and($export->map($exportedApplications->get($secondaryApplication->id))['job_priority_2'])->toBe($jobListing->title)
        ->and($export->map($exportedApplications->get($tertiaryApplication->id))['job_priority_3'])->toBe($jobListing->title)
        ->and($export->map($exportedApplications->get($legacyApplication->id))['job_priority_1'])->toBe($jobListing->title);
});
