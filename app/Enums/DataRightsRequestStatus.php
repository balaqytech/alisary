<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum DataRightsRequestStatus: string implements HasColor, HasLabel
{
    case New = 'new';
    case InReview = 'in_review';
    case Fulfilled = 'fulfilled';
    case Rejected = 'rejected';

    public function getLabel(): string
    {
        return match ($this) {
            self::New => 'جديد',
            self::InReview => 'قيد المراجعة',
            self::Fulfilled => 'تم التنفيذ',
            self::Rejected => 'مرفوض',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::New => 'info',
            self::InReview => 'warning',
            self::Fulfilled => 'success',
            self::Rejected => 'danger',
        };
    }
}
