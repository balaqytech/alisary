<?php

namespace App\Models;

use App\Enums\ListingKind;
use App\Enums\ListingStatus;
use Database\Factories\ListingFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Listing extends Model
{
    /** @use HasFactory<ListingFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $attributes = [
        'status' => 'draft',
        'attachments' => '[]',
        'form_fields' => '[]',
    ];

    protected function casts(): array
    {
        return [
            'kind' => ListingKind::class,
            'status' => ListingStatus::class,
            'published_at' => 'datetime',
            'closes_at' => 'datetime',
            'attachments' => 'array',
            'form_fields' => 'array',
        ];
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', ListingStatus::Published)
            ->where(function (Builder $query): void {
                $query->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    public function scopeKind(Builder $query, ListingKind $kind): Builder
    {
        return $query->where('kind', $kind);
    }

    public function isAcceptingSubmissions(): bool
    {
        return $this->status === ListingStatus::Published
            && ($this->published_at === null || $this->published_at->isPast())
            && ($this->closes_at === null || $this->closes_at->isFuture());
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
