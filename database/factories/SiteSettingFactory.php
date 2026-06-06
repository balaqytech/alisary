<?php

namespace Database\Factories;

use App\Models\SiteSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SiteSetting>
 */
class SiteSettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'site_name' => 'مجموعة العيسري',
            'slogan' => 'نُعِدُّهم لحياةٍ طيِّبة',
            'email' => 'info@alisary.com',
            'phone' => '+968 0000 0000',
            'address' => 'سلطنة عُمان',
            'assistant_url' => 'https://assistant.alisary.com',
            'seo_title' => 'مجموعة العيسري',
            'seo_description' => 'مجموعة العيسري القابضة العُمانية: نخدم الأطفال ومن يخدم الأطفال.',
            'social_links' => [],
        ];
    }
}
