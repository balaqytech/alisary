<?php

namespace App\Models;

use App\Enums\Governorate;
use App\Enums\JobApplicationStatus;
use App\Enums\JobTrack;
use App\Enums\ListingLocation;
use Database\Factories\JobApplicationFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class JobApplication extends Model
{
    /** @use HasFactory<JobApplicationFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $attributes = [
        'status' => 'new',
        'phone_country_code' => '+968',
        'previously_worked' => false,
        'consent_accurate' => false,
        'consent_ai' => false,
        'consent_pool' => false,
        'consent_transfer' => false,
    ];

    protected function casts(): array
    {
        return [
            'status' => JobApplicationStatus::class,
            'branch' => ListingLocation::class,
            'governorate' => Governorate::class,
            'track' => JobTrack::class,
            'contract_types' => 'array',
            'ready_date' => 'date',
            'previously_worked' => 'boolean',
            'consent_accurate' => 'boolean',
            'consent_ai' => 'boolean',
            'consent_pool' => 'boolean',
            'consent_transfer' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (JobApplication $application): void {
            if (empty($application->reference_number)) {
                $application->reference_number = self::generateReferenceNumber();
            }
        });
    }

    private static function generateReferenceNumber(): string
    {
        do {
            $reference = 'JA-'.now()->format('Ymd').'-'.strtoupper(Str::random(4));
        } while (self::where('reference_number', $reference)->exists());

        return $reference;
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function firstPriorityJobListing(): BelongsTo
    {
        return $this->belongsTo(JobListing::class, 'job_priority_1', 'job_code');
    }

    public function secondPriorityJobListing(): BelongsTo
    {
        return $this->belongsTo(JobListing::class, 'job_priority_2', 'job_code');
    }

    public function thirdPriorityJobListing(): BelongsTo
    {
        return $this->belongsTo(JobListing::class, 'job_priority_3', 'job_code');
    }

    public function firstPriorityJobTitle(): ?string
    {
        return $this->firstPriorityJobListing?->title ?? $this->job_priority_1;
    }

    public function secondPriorityJobTitle(): ?string
    {
        return $this->secondPriorityJobListing?->title ?? $this->job_priority_2;
    }

    public function thirdPriorityJobTitle(): ?string
    {
        return $this->thirdPriorityJobListing?->title ?? $this->job_priority_3;
    }

    public function scopeForJobListing(Builder $query, JobListing $jobListing): Builder
    {
        $jobReferences = collect([$jobListing->job_code, $jobListing->title])
            ->filter()
            ->unique()
            ->values()
            ->all();

        return $query->where(function (Builder $query) use ($jobReferences): void {
            $query
                ->whereIn('job_priority_1', $jobReferences)
                ->orWhereIn('job_priority_2', $jobReferences)
                ->orWhereIn('job_priority_3', $jobReferences);
        });
    }
}
