<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tontine>
 */
class TontineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amount = fake()->numberBetween(1000, 100000);
        $profit = $amount * (10 /100);
        return [
            'id' => Str::uuid(),
            'name' => fake()->word,
            'profit' => $profit,
            'delay' => fake()->numberBetween(1, 30),
            'delay_unity' => fake()->randomElement(['day', 'week', 'month', 'year']),
            'amount' => $amount,
            'number_of_members' => fake()->numberBetween(5, 20),
            'description' => fake()->paragraph,
            'status' => 'creating',
            // 'status' => fake()->randomElement(['creating', 'ongoing', 'suspended', 'completed']),
            // 'suspension_reason' => fake()->optional()->sentence,
            // 'suspension_date' => fake()->optional()->dateTimeThisMonth(),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null, // Soft delete field
            // 'user_id' => function () {
            //     return factory(App\User::class)->create()->id;
            // },
        ];
    }
}
