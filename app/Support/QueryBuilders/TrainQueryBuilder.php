<?php

namespace App\Support\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class TrainQueryBuilder extends Builder
{
    public function filterSeatsByPrice($minPrice, $maxPrice): TrainQueryBuilder
    {
        return $this->whereHas('carriages.seats', function ($query) use ($minPrice, $maxPrice) {
            $query->whereBetween('price', [$minPrice, $maxPrice]);
        });
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
        $minPrice = request('min_price');
        $maxPrice = request('max_price');

        if ($minPrice !== null && $maxPrice !== null) {
            $this->filterSeatsByPrice($minPrice, $maxPrice);
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
