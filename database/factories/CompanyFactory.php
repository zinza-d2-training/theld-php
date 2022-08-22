<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'logo' => 'images/company/default.png',
            'address' => fake()->text(30),
            'max_user' => rand(2,6),
            'expired_at' => '2024-08-16',
            'status' => 1
        ];
    }
}
