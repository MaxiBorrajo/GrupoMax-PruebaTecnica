<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "first_name" => fake()->firstName(),
            "last_name" => fake()->lastName(),
            "email" => fake()->unique()->safeEmail(),
            "age" => fake()->numberBetween(1, 99),
            "status" => fake()->randomElement(['ACTIVE', 'INACTIVE']),
            "phone_number" => fake()->phoneNumber(),
            "user_id" => 151
        ];
    }
}
