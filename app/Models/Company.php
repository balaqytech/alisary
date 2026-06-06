<?php

namespace App\Models;

use Database\Factories\CompanyFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /** @use HasFactory<CompanyFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $attributes = [
        'brand_color' => '#1C463C',
        'status' => 'active',
        'sort_order' => 0,
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }
}
