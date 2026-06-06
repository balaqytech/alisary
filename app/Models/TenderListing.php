<?php

namespace App\Models;

use App\Enums\ListingLocation;
use App\Enums\ListingStatus;
use Database\Factories\TenderListingFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class TenderListing extends Model
{
    /** @use HasFactory<TenderListingFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $attributes = [
        'status' => 'draft',
        'form_steps' => '[]',
    ];

    protected function casts(): array
    {
        return [
            'status' => ListingStatus::class,
            'location' => ListingLocation::class,
            'published_at' => 'datetime',
            'last_day_to_apply' => 'datetime',
            'form_steps' => 'array',
        ];
    }

    public function contractor(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'contractor_id');
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
                $query->whereNull('last_day_to_apply')->orWhere('last_day_to_apply', '>=', now());
            });
    }

    public function isAcceptingSubmissions(): bool
    {
        return $this->status === ListingStatus::Published
            && ($this->published_at === null || $this->published_at->isPast())
            && ($this->last_day_to_apply === null || $this->last_day_to_apply->isFuture());
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
