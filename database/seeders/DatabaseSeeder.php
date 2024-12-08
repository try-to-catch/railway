<?php

namespace Database\Seeders;

use App\Models\Carriage;
use App\Models\Seat;
use App\Models\Train;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Train::factory(10)->has(
            Carriage::factory(5)->has(
                Seat::factory(20)
            )
        )->create();
    }
}
