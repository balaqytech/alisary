<?php

namespace App\Models;

use App\Actions\GenerateJobListingCode;
use App\Enums\JobLevel;
use App\Enums\JobType;
use App\Enums\ListingLocation;
use App\Enums\ListingStatus;
use Database\Factories\JobListingFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class JobListing extends Model
{
    /** @use HasFactory<JobListingFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $attributes = [
        'status' => 'draft',
        'form_fields' => '[]',
    ];

    /**
     * @var array<int, string>
     */
    protected static array $immutableReferenceColumns = [
        'job_code',
        'job_code_year',
        'job_code_sequence',
    ];

    protected function casts(): array
    {
        return [
            'status' => ListingStatus::class,
            'type' => JobType::class,
            'job_level' => JobLevel::class,
            'location' => ListingLocation::class,
            'published_at' => 'datetime',
            'expires_at' => 'datetime',
            'job_code_year' => 'integer',
            'job_code_sequence' => 'integer',
            'form_fields' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (JobListing $jobListing): void {
            if ($jobListing->job_code === null) {
                $jobListing->job_code = app(GenerateJobListingCode::class)->handle($jobListing);
            }
        });

        static::updating(function (JobListing $jobListing): void {
            foreach (self::$immutableReferenceColumns as $column) {
                if ($jobListing->isDirty($column)) {
                    $jobListing->{$column} = $jobListing->getOriginal($column);
                }
            }
        });
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function jobFamily(): BelongsTo
    {
        return $this->belongsTo(JobFamily::class);
    }

    public function submissions(): MorphMany
    {
        return $this->morphMany(Submission::class, 'submittable');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', ListingStatus::Published)
            ->where(function (Builder $query): void {
                $query->whereNull('published_at')->orWhere('published_at', '<=', now());
            })
            ->where(function (Builder $query): void {
                $query->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            });
    }

    public function isAcceptingSubmissions(): bool
    {
        return $this->status === ListingStatus::Published
            && ($this->published_at === null || $this->published_at->isPast())
            && ($this->expires_at === null || $this->expires_at->isFuture());
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
