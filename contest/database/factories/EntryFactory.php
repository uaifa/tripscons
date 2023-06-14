<?php

namespace Database\Factories;

use App\Models\Contest;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entry>
 */
class EntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = FakerFactory::create();
        return [
            'contest_id' => rand(1,10),
            'user_id' => rand(1, 1000),
            'title' => $faker->text(50),
            'media_path' => 'http://localhost:8000/media/hunza.jpg',
            'description' => $faker->text(200),
        ];
    }
}
