<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id'  => Project::inRandomOrder()->first()?->id ?? Project::factory(),
            'assignee_id' => $this->faker->boolean(75)
                                ? User::inRandomOrder()->first()?->id
                                : null,
            'title'       => $this->faker->sentence(5),
            'status'      => $this->faker->randomElement(['pending', 'in_progress', 'done']),
            'description' => $this->faker->paragraph(2),
        ];
    }
}
