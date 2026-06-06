<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'slug' => $this->faker->unique()->slug(2),
            'description' => $this->faker->paragraph(),
            'website_url' => $this->faker->url(),
            'brand_color' => '#1C463C',
            'status' => 'active',
            'sort_order' => $this->faker->numberBetween(1, 20),
        ];
    }
}
