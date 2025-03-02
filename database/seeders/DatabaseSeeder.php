<?php

namespace Database\Seeders;

use App\Models\Carriage;
use App\Models\Seat;
use App\Models\TicketPrice;
use App\Models\Train;
use App\Models\TrainSchedule;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 10 trains
        Train::factory(10)
            ->create()
            ->each(function (Train $train) {
                // Create 5 carriages for each train
                $carriages = Carriage::factory(5)
                    ->create(['train_id' => $train->id]);

                $seats = collect();

                // Create 20 seats for each carriage
                foreach ($carriages as $carriage) {
                    $carriage_seats = Seat::factory(20)
                        ->create(['carriage_id' => $carriage->id]);
                    $seats = $seats->merge($carriage_seats);
                }

                // Create 3 schedules for each train
                $schedules = TrainSchedule::factory(3)
                    ->create(['train_id' => $train->id]);

                // Create prices for each seat and schedule combination on the train
                foreach ($schedules as $schedule) {
                    foreach ($seats as $seat) {
                        TicketPrice::factory()->create([
                            'seat_id' => $seat->id,
                            'train_schedule_id' => $schedule->id,
                        ]);
                    }
                }
            });
    }
}
