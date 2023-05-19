<?php

namespace Database\Factories;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create('id_ID');
        return [
            'event_id' => fake()->numberBetween(1, 20),
            'price' => fake()->randomFloat(2, 1, 1000),
            'name' => "Tickets Tipe" . fake()->numberBetween(1, 6)
        ];
    }
}
