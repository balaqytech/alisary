<?php

namespace App\Support;

class CountryDialCodes
{
    public const DEFAULT = '+968';

    /**
     * @return array<int, array{country: string, code: string}>
     */
    public static function options(): array
    {
        return [
            ['country' => 'عُمان', 'code' => '+968'],
            ['country' => 'السعودية', 'code' => '+966'],
            ['country' => 'الإمارات', 'code' => '+971'],
            ['country' => 'البحرين', 'code' => '+973'],
            ['country' => 'الكويت', 'code' => '+965'],
            ['country' => 'قطر', 'code' => '+974'],
            ['country' => 'اليمن', 'code' => '+967'],
            ['country' => 'الأردن', 'code' => '+962'],
            ['country' => 'العراق', 'code' => '+964'],
            ['country' => 'فلسطين', 'code' => '+970'],
            ['country' => 'لبنان', 'code' => '+961'],
            ['country' => 'سوريا', 'code' => '+963'],
            ['country' => 'مصر', 'code' => '+20'],
            ['country' => 'السودان', 'code' => '+249'],
            ['country' => 'ليبيا', 'code' => '+218'],
            ['country' => 'تونس', 'code' => '+216'],
            ['country' => 'الجزائر', 'code' => '+213'],
            ['country' => 'المغرب', 'code' => '+212'],
            ['country' => 'موريتانيا', 'code' => '+222'],
            ['country' => 'الصومال', 'code' => '+252'],
            ['country' => 'جيبوتي', 'code' => '+253'],
            ['country' => 'جزر القمر', 'code' => '+269'],
            ['country' => 'تركيا', 'code' => '+90'],
            ['country' => 'إيران', 'code' => '+98'],
            ['country' => 'الهند', 'code' => '+91'],
            ['country' => 'باكستان', 'code' => '+92'],
            ['country' => 'بنغلاديش', 'code' => '+880'],
            ['country' => 'الفلبين', 'code' => '+63'],
            ['country' => 'إندونيسيا', 'code' => '+62'],
            ['country' => 'ماليزيا', 'code' => '+60'],
            ['country' => 'الصين', 'code' => '+86'],
            ['country' => 'المملكة المتحدة', 'code' => '+44'],
            ['country' => 'الولايات المتحدة / كندا', 'code' => '+1'],
            ['country' => 'فرنسا', 'code' => '+33'],
            ['country' => 'ألمانيا', 'code' => '+49'],
            ['country' => 'إيطاليا', 'code' => '+39'],
            ['country' => 'إسبانيا', 'code' => '+34'],
            ['country' => 'هولندا', 'code' => '+31'],
            ['country' => 'أستراليا', 'code' => '+61'],
            ['country' => 'نيوزيلندا', 'code' => '+64'],
        ];
    }

    /**
     * @return array<int, string>
     */
    public static function allowedCodes(): array
    {
        return collect(self::options())
            ->pluck('code')
            ->unique()
            ->values()
            ->all();
    }
}
