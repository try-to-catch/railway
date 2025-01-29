<?php

namespace Database\Seeders;

use App\Models\Carriage;
use App\Models\Seat;
use App\Models\Train;
use App\Models\TrainSchedule;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Train::factory(10)
            ->has(
                Carriage::factory(5)->has(
                    Seat::factory(20)
                )
            )
            ->has(
                TrainSchedule::factory(5)
            )
            ->create();
    }
}
