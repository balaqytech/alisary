<?php

namespace App\Enums;

enum DataRightsRequestStatus: string
{
    case New = 'new';
    case InReview = 'in_review';
    case Fulfilled = 'fulfilled';
    case Rejected = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::New => 'جديد',
            self::InReview => 'قيد المراجعة',
            self::Fulfilled => 'تم التنفيذ',
            self::Rejected => 'مرفوض',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::New => 'info',
            self::InReview => 'warning',
            self::Fulfilled => 'success',
            self::Rejected => 'danger',
        };
    }
}
