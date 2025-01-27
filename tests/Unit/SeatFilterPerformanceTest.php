<?php

namespace Tests\Unit;

use App\Models\Carriage;
use App\Models\Seat;
use App\Models\Train;
use App\Support\QueryBuilders\TrainQueryBuilder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeatFilterPerformanceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Создание тестовых данных
        Train::factory(10)->has(
            Carriage::factory(5)
        )->create();
    }

    public function testFilterSeatsByPricePerformance()
    {
        $this->benchmarkFilterSeatsByPrice(1);
        $this->benchmarkFilterSeatsByPrice(10);
        $this->benchmarkFilterSeatsByPrice(100);
        $this->benchmarkFilterSeatsByPrice(1000);
    }

    protected function benchmarkFilterSeatsByPrice(int $seatCount): void
    {
        // Обновление количества мест в каждом вагоне
        Train::all()->each(function ($train) use ($seatCount) {
            $train->carriages->each(function ($carriage) use ($seatCount) {
                $carriage->seats()->delete();
                Seat::factory($seatCount)->create(['carriage_id' => $carriage->id]);
            });
        });

        $minPrice = 10;
        $maxPrice = 100;

        // Измерение времени выполнения для filterSeatsByPriceBTree
        $startTime = microtime(true);
        Train::query()->filterSeatsByPriceBTree($minPrice, $maxPrice)->get();
        $bTreeDuration = microtime(true) - $startTime;

        // Измерение времени выполнения для filterSeatsByPriceBinaryTree
        $startTime = microtime(true);
        Train::query()->filterSeatsByPriceBinaryTree($minPrice, $maxPrice)->get();
        $binaryTreeDuration = microtime(true) - $startTime;

        echo "Seat Count: $seatCount\n";
        echo "B-Tree Duration: $bTreeDuration seconds\n";
        echo "Binary Tree Duration: $binaryTreeDuration seconds\n";
        echo "\n";
    }
}
