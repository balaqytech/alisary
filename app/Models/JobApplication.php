<?php

namespace App\Models;

use App\Enums\JobApplicationStatus;
use Database\Factories\JobApplicationFactory;
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
}
