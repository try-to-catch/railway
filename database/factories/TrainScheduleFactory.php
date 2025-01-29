<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TrainSchedule>
 */
class TrainScheduleFactory extends Factory
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

        $arrival = fake()->dateTimeBetween($departure, now()->parse($departure)->addHours(rand(1, 10)));

        return [
            'departure' => $departure,
            'arrival' => $arrival,
        ];
    }
}
