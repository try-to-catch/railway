<?php

namespace Database\Factories;

use App\Models\Seat;
use App\Models\TrainSchedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'seat_id' => Seat::factory(),
            'train_schedule_id' => TrainSchedule::factory(),
        ];
    }
}
