<?php

namespace Database\Factories;

use App\Models\Train;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Train>
 */
class TrainFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $departureFrom = now()->addWeek()->addDays(rand(1, 7));

        $departure = fake()->dateTimeBetween($departureFrom, $departureFrom->addDays(rand(1, 7)));

        $arrival = fake()->dateTimeBetween($departure, now()->parse($departure)->addHours(rand(10, 50)));

        return [
            'name' => fake()->name(),

            'from' => fake()->city(),
            'to' => fake()->city(),

            'departure' => $departure,
            'arrival' => $arrival,
        ];
    }
}
