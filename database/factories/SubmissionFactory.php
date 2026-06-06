<?php

namespace Database\Factories;

use App\Models\JobListing;
use App\Models\Submission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Submission>
 */
class SubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'submittable_type' => JobListing::class,
            'submittable_id' => JobListing::factory(),
            'full_name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'birthday' => $this->faker->date(),
            'cv_path' => null,
            'answers' => [],
            'files' => [],
        ];
    }
}
