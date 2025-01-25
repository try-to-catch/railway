<?php

namespace App\Support\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class TrainQueryBuilder extends Builder
{
    public function filterSeatsByPriceBTree($minPriceB, $maxPriceB): TrainQueryBuilder
    {
        $trains = $this->with(['carriages.seats'])->get();

        $filteredTrains = $trains->filter(function ($train) use ($minPriceB, $maxPriceB) {
            foreach ($train->carriages as $carriage) {
                $sortedSeats = $carriage->seats->sortBy('price');
                foreach ($sortedSeats as $seat) {
                    if ($seat->price >= $minPriceB && $seat->price <= $maxPriceB) {
                        return true;
                    }
                }
            }

            return false;
        });

        return $this->whereIn('id', $filteredTrains->pluck('id'));
    }

    public function filterSeatsByPriceBinaryTree($minPriceBinary, $maxPriceBinary): TrainQueryBuilder
    {
        $trains = $this->with(['carriages.seats'])->get();

        $filteredTrains = $trains->filter(function ($train) use ($minPriceBinary, $maxPriceBinary) {
            foreach ($train->carriages as $carriage) {
                foreach ($carriage->seats as $seat) {
                    if ($seat->price >= $minPriceBinary && $seat->price <= $maxPriceBinary) {
                        return true;
                    }
                }
            }

            return false;
        });

        return $this->whereIn('id', $filteredTrains->pluck('id'));
    }

    public function filterByRoute($from, $to): TrainQueryBuilder
    {
        return $this->where('from', $from)->where('to', $to);
    }

    public function filterByDate($date): TrainQueryBuilder
    {
        return $this->whereDate('departure', $date);
    }

    public function filter(): TrainQueryBuilder
    {
        $minPriceB = request('min_price_b');
        $maxPriceB = request('max_price_b');

        if ($minPriceB !== null && $maxPriceB !== null) {
            $this->filterSeatsByPriceBTree($minPriceB, $maxPriceB);
        }

        $minPriceBinary = request('min_price_binary');
        $maxPriceBinary = request('max_price_binary');

        if ($minPriceBinary !== null && $maxPriceBinary !== null) {
            $this->filterSeatsByPriceBinaryTree($minPriceBinary, $maxPriceBinary);
        }

        $from = request('from');
        $to = request('to');

        if ($from !== null && $to !== null) {
            $this->filterByRoute($from, $to);
        }

        $date = request('date');

        if ($date !== null) {
            $this->filterByDate($date);
        }

        return $this;
    }
}
