<?php

namespace Database\Factories;

use App\Enums\JobType;
use App\Enums\ListingLocation;
use App\Enums\ListingStatus;
use App\Models\Company;
use App\Models\JobListing;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<JobListing>
 */
class JobListingFactory extends Factory
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
            'status' => ListingStatus::Published,
            'title' => $title,
            'slug' => Str::slug($title).'-'.$this->faker->unique()->numberBetween(100, 999),
            'excerpt' => $this->faker->sentence(12),
            'company_id' => Company::factory(),
            'description' => $this->faker->paragraphs(3, true),
            'type' => $this->faker->randomElement(JobType::cases()),
            'expires_at' => now()->addMonth(),
            'location' => $this->faker->randomElement(ListingLocation::cases()),
            'published_at' => now()->subDay(),
            'form_fields' => [],
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (): array => [
            'status' => ListingStatus::Draft,
            'published_at' => null,
        ]);
    }

    public function expired(): static
    {
        return $this->state(fn (): array => [
            'expires_at' => now()->subDay(),
        ]);
    }
}
