<?php

namespace Database\Factories;

use App\Models\JobFamily;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<JobFamily>
 */
class JobFamilyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->jobTitle();

        return [
            'name' => $name,
            'code' => Str::upper($this->faker->unique()->lexify('???')),
            'status' => 'active',
            'sort_order' => $this->faker->numberBetween(1, 20),
        ];
    }
}
