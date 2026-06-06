<?php

namespace Database\Factories;

use App\Enums\CustomFieldType;
use App\Enums\ListingKind;
use App\Enums\ListingStatus;
use App\Models\Listing;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(3);

        return [
            'kind' => ListingKind::Job,
            'status' => ListingStatus::Published,
            'title' => $title,
            'slug' => Str::slug($title).'-'.$this->faker->unique()->numberBetween(1000, 9999),
            'summary' => $this->faker->sentence(),
            'description' => $this->faker->paragraphs(3, true),
            'location' => 'مسقط',
            'department' => 'الإدارة',
            'published_at' => now()->subDay(),
            'closes_at' => now()->addMonth(),
            'attachments' => [],
            'form_fields' => [
                [
                    'key' => 'experience_years',
                    'label' => 'سنوات الخبرة',
                    'type' => CustomFieldType::Number->value,
                    'required' => true,
                ],
            ],
        ];
    }

    public function tender(): static
    {
        return $this->state(fn (): array => [
            'kind' => ListingKind::Tender,
        ]);
    }

    public function closed(): static
    {
        return $this->state(fn (): array => [
            'status' => ListingStatus::Closed,
            'closes_at' => now()->subDay(),
        ]);
    }
}
