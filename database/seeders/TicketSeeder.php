<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;



class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prices = [10000, 15000, 250000, 50000, 75000, 100000, 12000, 125000, 200000];
        $faker = Faker::create();
        // Create events
        $events = Event::factory(20)->create();
        foreach ($events as $event) {
            $numberOfTickets = $faker->numberBetween(1, 4);
            for ($i = 0; $i < $numberOfTickets; $i++) {
                Ticket::create(
                    [
                        'event_id' => $event->id,
                        'name' => 'Ticket Type' . $faker->numberBetween(1, 4),
                        'price' => $faker->randomElement($prices),
                        'stock' => $faker->numberBetween(80, 1500),
                        'sold' => 0
                    ]
                );
            }
        }
    }
}
