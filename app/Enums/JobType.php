<?php

namespace App\Enums;

enum JobType: string
{
    case Remote = 'remote';
    case FullTime = 'full_time';
    case PartTime = 'part_time';
    case Contract = 'contract';
    case Internship = 'internship';

    public function label(): string
    {
        return match ($this) {
            self::Remote => 'عن بعد',
            self::FullTime => 'دوام كامل',
            self::PartTime => 'دوام جزئي',
            self::Contract => 'عقد',
            self::Internship => 'تدريب',
        };
    }
}
