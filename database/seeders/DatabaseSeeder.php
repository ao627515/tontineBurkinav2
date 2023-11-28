<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Participant;
use App\Models\User;
use App\Models\Tontine;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'last_name' => "Ouédraogo",
            'first_name' => "Abdoul Aziz",
            'email' => "ao627515@gmail.com",
            'phone_number' => 73471085,
            'role' => fake()->randomElement(['user', 'administrator']),
        ]);

        Tontine::factory(100)->create();

        Participant::factory(100)->create();

    }
}
