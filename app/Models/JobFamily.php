<?php

namespace App\Models;

use App\Enums\JobTrack;
use Database\Factories\JobFamilyFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobFamily extends Model
{
    /** @use HasFactory<JobFamilyFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $attributes = [
        'status' => 'active',
        'sort_order' => 0,
    ];

    protected function casts(): array
    {
        return [
            'track' => JobTrack::class,
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function jobListings(): HasMany
    {
        return $this->hasMany(JobListing::class);
    }
}
