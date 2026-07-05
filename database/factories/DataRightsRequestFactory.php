<?php

namespace Database\Factories;

use App\Enums\DataRightsRequestStatus;
use App\Models\DataRightsRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DataRightsRequest>
 */
class DataRightsRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => DataRightsRequestStatus::New,
            'request_type' => fake()->randomElement(DataRightsRequest::REQUEST_TYPES),
            'email' => fake()->safeEmail(),
            'details' => fake()->paragraph(),
            'submitted_from_url' => fake()->url(),
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
        ];
    }
}
