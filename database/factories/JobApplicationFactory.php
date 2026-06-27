<?php

namespace Database\Factories;

use App\Enums\JobApplicationStatus;
use App\Models\Company;
use App\Models\JobApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<JobApplication>
 */
class JobApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => JobApplicationStatus::New,
            'full_name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'nationality' => 'عُماني',
            'country' => 'عُمان',
            'city' => 'مسقط',
            'company_id' => Company::factory(),
            'job_priority_1' => fake()->jobTitle(),
            'job_priority_2' => null,
            'job_priority_3' => null,
            'contract_types' => ['دوام كامل'],
            'ready_date' => now()->addMonth()->toDateString(),
            'expected_salary' => fake()->numberBetween(500, 3000).' ريال',
            'years_experience' => fake()->numberBetween(0, 20),
            'previously_worked' => false,
            'previously_worked_where' => null,
            'tools_and_ai' => null,
            'cv_link' => null,
            'cv_path' => null,
            'q_automate' => fake()->paragraph(),
            'q_learn' => fake()->paragraph(),
            'q_own' => fake()->paragraph(),
            'q_brand' => fake()->paragraph(),
            'q_ethics' => fake()->paragraph(),
            'q_mission' => fake()->paragraph(),
            'future_aspirations' => null,
            'q_build' => null,
            'extra_notes' => null,
            'consent_accurate' => true,
            'consent_ai' => true,
            'consent_pool' => false,
            'consent_transfer' => false,
        ];
    }
}
