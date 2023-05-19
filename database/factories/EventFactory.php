<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Factory as Faker;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create('id_ID');
        $categories = [1, 2, 3, 4, 5];
        return [
            'name' => "Event " . Str::upper(Str::random(2)),
            'date' => $faker->dateTimeBetween('now', '+2 months')->format('d-m-Y'),
            'location' => $faker->city(),
            'description' => $faker->paragraph(4),
            'image' => "400x300.png",
            'category_id' => $faker->randomElement($categories),
            'highlight' => '<li>Festival musik kolaboratif di Surabaya yang akan menampilkan berbagai musisi tanah air terkemuka, mulai dari D’Masiv, Armada, Yura, Nadin Amizah, dan banyak lagi yang akan segera diumumkan!</li>
            <li>Konser offline.</li>
            <li>Cocok Untuk: Geng Asyik.</li>',
            'other' => '<li>Wajib sudah melakukan vaksin dan terdaftar di aplikasi PeduliLindungi.</li>'
        ];
    }
}
