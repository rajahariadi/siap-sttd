<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Registration>
 */
class RegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Gelombang I', 'Gelombang II', 'Gelombang III']),
            'year' => $this->faker->randomElement([2020, 2021, 2022, 2023, 2024, 2025]),
        ];
    }
}
