<?php

namespace App\Support;

final class JobExperienceRanges
{
    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return [
            '1-3' => 'من ١ إلى ٣',
            '4-7' => 'من ٤ إلى ٧',
            '8-10' => 'من ٨ إلى ١٠',
            '10+' => 'أكثر من ١٠ سنوات',
        ];
    }

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_keys(self::options());
    }

    public static function label(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return $value;
        }

        return self::options()[$value] ?? $value;
    }
}
