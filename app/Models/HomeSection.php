<?php

namespace App\Models;

use Database\Factories\HomeSectionFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSection extends Model
{
    /** @use HasFactory<HomeSectionFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $attributes = [
        'content' => '[]',
        'is_active' => true,
        'sort_order' => 0,
    ];

    protected function casts(): array
    {
        return [
            'content' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
