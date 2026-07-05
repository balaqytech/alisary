<?php

namespace App\Models;

use App\Enums\DataRightsRequestStatus;
use Database\Factories\DataRightsRequestFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DataRightsRequest extends Model
{
    /** @use HasFactory<DataRightsRequestFactory> */
    use HasFactory;

    public const REQUEST_TYPES = [
        'الوصول والعلم',
        'التصحيح والتحديث',
        'المحو',
        'الحصول على نسخة',
        'النقل',
        'سحب الموافقة',
        'وقف المعالجة لحين البتّ',
    ];

    protected $guarded = [];

    protected $attributes = [
        'status' => 'new',
    ];

    protected function casts(): array
    {
        return [
            'status' => DataRightsRequestStatus::class,
            'resolved_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (DataRightsRequest $request): void {
            if (empty($request->reference_number)) {
                $request->reference_number = self::generateReferenceNumber();
            }
        });
    }

    private static function generateReferenceNumber(): string
    {
        do {
            $reference = 'DR-'.now()->format('Ymd').'-'.strtoupper(Str::random(4));
        } while (self::query()->where('reference_number', $reference)->exists());

        return $reference;
    }
}
