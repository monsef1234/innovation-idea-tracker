<?php

namespace Database\Seeders;

use App\Models\Idea;
use App\Models\User;
use App\Models\Vote;
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
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@example.com',
            'password' => 'password',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'submitter@example.com',
            'password' => 'password',
            'role' => 'submitter',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'reviewer@example.com',
            'password' => 'password',
            'role' => 'reviewer',
        ]);

        Idea::factory()->count(10)->create();

        Vote::factory()->count(10)->create();
    }
}
