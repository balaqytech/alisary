<?php

namespace App\Models;

use Database\Factories\SiteSettingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    /** @use HasFactory<SiteSettingFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $attributes = [
        'site_name' => 'مجموعة العيسري',
        'slogan' => 'نُعِدُّهم لحياةٍ طيِّبة',
    ];

    protected function casts(): array
    {
        return [
            'social_links' => 'array',
        ];
    }

    public static function current(): self
    {
        return self::query()->firstOrCreate([]);
    }
}
