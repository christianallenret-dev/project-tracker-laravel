<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'        => $this->faker->unique()->bs() . ' Project',
            'description' => $this->faker->paragraph(3),
            'location'    => $this->faker->city() . ', ' . $this->faker->country(),
            'date'        => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'slots'       => $this->faker->numberBetween(1, 20),
        ];
    }
}
