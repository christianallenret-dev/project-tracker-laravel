<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a default test user + 10 additional users
        User::factory()->create([
            'name'  => 'Test User',
            'email' => 'test@example.com',
            'is_manager' => true,
        ]);

        User::factory(10)->create();

        // Seed projects first (tasks depend on projects)
        $this->call([
            ProjectSeeder::class,
            TaskSeeder::class,
        ]);
    }
}
