<?php

namespace App\Support;

class NumberLocalizer
{
    /**
     * Convert Latin and Arabic-Indic digits to Eastern Arabic numerals.
     */
    public static function eastern(mixed $value): string
    {
        return strtr((string) $value, [
            '0' => '٠',
            '1' => '١',
            '2' => '٢',
            '3' => '٣',
            '4' => '٤',
            '5' => '٥',
            '6' => '٦',
            '7' => '٧',
            '8' => '٨',
            '9' => '٩',
            '۰' => '٠',
            '۱' => '١',
            '۲' => '٢',
            '۳' => '٣',
            '۴' => '٤',
            '۵' => '٥',
            '۶' => '٦',
            '۷' => '٧',
            '۸' => '٨',
            '۹' => '٩',
        ]);
    }
}
