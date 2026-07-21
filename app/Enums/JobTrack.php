<?php

namespace App\Enums;

enum JobTrack: string
{
    case Teach = 'teach';
    case Ops = 'ops';
    case Lead = 'lead';
    case Support = 'support';

    public function label(): string
    {
        return match ($this) {
            self::Teach => 'تدريس',
            self::Ops => 'تنسيق وعمليات',
            self::Lead => 'قيادة / إدارة',
            self::Support => 'إسناد وخدمات',
        };
    }
}
