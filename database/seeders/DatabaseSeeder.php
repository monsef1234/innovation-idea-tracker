<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Submitter',
            'email' => 'submitter@example.com',
            'password' => Hash::make('password'),
            'role' => 'submitter',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Reviewer',
            'email' => 'reviewer@example.com',
            'password' => Hash::make('password'),
            'role' => 'reviewer',
            'email_verified_at' => now(),
        ]);
    }
}
