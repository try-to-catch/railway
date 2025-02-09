<?php

namespace App\Support\QueryBuilders;

use App\Utilities\BTree\BTree;
use App\Utilities\LinkedList;
use Illuminate\Database\Eloquent\Builder;

class TrainQueryBuilder extends Builder
{
    public function filterSeatsByPriceBTree($minPrice, $maxPrice): self
    {
        $trains = $this->with(['carriages.seats'])->get();

        // Create B-tree and insert all seats
        $bTree = new BTree(3); // degree = 3

        foreach ($trains as $train) {
            foreach ($train->carriages as $carriage) {
                foreach ($carriage->seats as $seat) {
                    $seatData = [
                        'seat' => $seat,
                        'carriage' => $carriage,
                        'train' => $train
                    ];
                    $bTree->insert($seat->price, $seatData);
                }
            }
        }

        // Get all seats in the given price range
        $filteredSeats = $bTree->searchRange($minPrice, $maxPrice);

        // Collect train IDs that have seats in the given range
        $trainIds = collect($filteredSeats)
            ->pluck('train.id')
            ->unique()
            ->values()
            ->all();

        // Apply filter by train IDs
        return $this->whereIn('trains.id', $trainIds);
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

        return $this->whereIn('trains.id', $filteredTrains->pluck('trains.id'));
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

    public function filterSeatsByPriceLinkedList($minPrice, $maxPrice): \Illuminate\Database\Eloquent\Builder
    {
        // Загружаем поезда с вагонами и местами
        $trains = $this->with(['carriages.seats'])->get();

        // Создаем связный список поездов
        $trainList = new LinkedList();
        foreach ($trains as $train) {
            $trainList->add($train);
        }

        // Фильтруем поезда через связный список
        $filteredTrains = [];
        $currentTrain = $trainList->getHead();
        while ($currentTrain !== null) {
            $train = $currentTrain->data;

            // Создаем связный список вагонов для текущего поезда
            $carriageList = new LinkedList();
            foreach ($train->carriages as $carriage) {
                $carriageList->add($carriage);
            }

            // Проходим по каждому вагону
            $currentCarriage = $carriageList->getHead();
            while ($currentCarriage !== null) {
                $carriage = $currentCarriage->data;

                // Создаем связный список мест
                $seatList = new LinkedList();
                foreach ($carriage->seats as $seat) {
                    $seatList->add($seat);
                }

                // Проходим по всем местам в вагоне
                $currentSeat = $seatList->getHead();
                while ($currentSeat !== null) {
                    if ($currentSeat->data->price >= $minPrice && $currentSeat->data->price <= $maxPrice) {
                        $filteredTrains[] = $train->id;
                        break 2; // Выходим из цикла вагонов, если поезд подходит
                    }
                    $currentSeat = $currentSeat->next;
                }

                $currentCarriage = $currentCarriage->next;
            }

            $currentTrain = $currentTrain->next;
        }

        // Возвращаем запрос с отфильтрованными поездами
        return $this->whereIn('trains.id', $filteredTrains);
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
