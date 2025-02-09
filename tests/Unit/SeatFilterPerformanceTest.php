<?php

namespace Tests\Unit;

use App\Models\Carriage;
use App\Models\Seat;
use App\Models\Train;
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

    public function test_filter_seats_by_price_performance(): void
    {
        $this->benchmarkFilterSeatsByPrice(1, 5,10);
        $this->benchmarkFilterSeatsByPrice(10, 25, 25);
        $this->benchmarkFilterSeatsByPrice(100, 50, 50);
    }

    protected function benchmarkFilterSeatsByPrice(int $seatCount, $carriageCount, $trainCount): void
    {
        Train::query()->delete();

        Train::factory($trainCount)->create();

        Train::all()->each(function ($train) use ($carriageCount, $seatCount) {
            $train->carriages()->delete();
            Carriage::factory($carriageCount)->create(['train_id' => $train->id]);

            $train->carriages->each(function ($carriage) use ($seatCount) {
                $carriage->seats()->delete();
                Seat::factory($seatCount)->create(['carriage_id' => $carriage->id]);
            });
        });

        $minPrice = 10;
        $maxPrice = 100;

        // Измерение времени выполнения для filterSeatsByPriceBinaryTree
        $startTime = microtime(true);
        Train::query()->filterSeatsByPriceLinkedList($minPrice, $maxPrice)->get();
        $binaryTreeDuration = microtime(true) - $startTime;

        // Измерение времени выполнения для filterSeatsByPriceBTree
        $startTime = microtime(true);
        Train::query()->filterSeatsByPriceBTree($minPrice, $maxPrice)->get();
        $bTreeDuration = microtime(true) - $startTime;

        echo "Seat Count: $seatCount\n";
        echo "B-Tree Duration: $bTreeDuration seconds\n";
        echo "Linked List Duration: $binaryTreeDuration seconds\n";
        echo "\n";

        $this->assertTrue(true, 'Benchmark completed successfully.');
    }
}
