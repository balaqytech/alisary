<?php

namespace App\Enums;

enum JobApplicationStatus: string
{
    case New = 'new';
    case Reviewing = 'reviewing';
    case Shortlisted = 'shortlisted';
    case Rejected = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::New => 'جديد',
            self::Reviewing => 'قيد المراجعة',
            self::Shortlisted => 'مرشح',
            self::Rejected => 'مرفوض',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::New => 'info',
            self::Reviewing => 'warning',
            self::Shortlisted => 'success',
            self::Rejected => 'danger',
        };
    }
}
