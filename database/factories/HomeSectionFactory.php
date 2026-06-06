<?php

namespace Database\Factories;

use App\Models\HomeSection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HomeSection>
 */
class HomeSectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key' => $this->faker->unique()->slug(2),
            'title' => $this->faker->sentence(3),
            'eyebrow' => $this->faker->word(),
            'content' => [],
            'is_active' => true,
            'sort_order' => $this->faker->numberBetween(1, 20),
        ];
    }
}
