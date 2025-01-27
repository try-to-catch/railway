<?php

namespace App\Support\QueryBuilders;

use App\Utilities\LinkedList;
use Illuminate\Database\Eloquent\Builder;

class TrainQueryBuilder extends Builder
{
    public function filterSeatsByPriceBTree($minPriceB, $maxPriceB): TrainQueryBuilder
    {
        $trains = $this->with(['carriages.seats'])->get();

        $filteredTrains = $trains->filter(function ($train) use ($minPriceB, $maxPriceB) {
            foreach ($train->carriages as $carriage) {
                $sortedSeats = $carriage->seats;
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
        if ($from ) {
            $this->where('from', 'like', '%'.$from.'%');
        }

        if ($to) {
            $this->where('to', 'like', '%'.$to.'%');
        }

        return $this;
    }

    public function filterByDate($date): TrainQueryBuilder
    {
        return $this->whereDate('departure', $date);
    }

    public function filterSeatsByPriceLinkedList($minPrice, $maxPrice): Builder
    {
        $trains = $this->with(['carriages.seats'])->get();

        $filteredTrains = $trains->filter(function ($train) use ($minPrice, $maxPrice) {
            foreach ($train->carriages as $carriage) {
                // Создаем связный список для мест
                $seatList = new LinkedList();
                foreach ($carriage->seats as $seat) {
                    $seatList->add($seat);
                }

                // Проходим по всем местам в связном списке
                $current = $seatList->getHead();
                while ($current !== null) {
                    if ($current->seat->price >= $minPrice && $current->seat->price <= $maxPrice) {
                        return true;
                    }
                    $current = $current->next;
                }
            }

            return false;
        });

        // Возвращаем запрос с отфильтрованными по цене поездами
        return $this->whereIn('id', $filteredTrains->pluck('id'));
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
            $this->filterSeatsByPriceLinkedList($minPriceBinary, $maxPriceBinary);
        }

        $from = request('from');
        $to = request('to');

        if ($from || $to) {
            $this->filterByRoute($from, $to);
        }

        $date = request('date');

        if ($date !== null) {
            $this->filterByDate($date);
        }

        return $this;
    }
}
