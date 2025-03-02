<?php

namespace App\Support\QueryBuilders;

use App\Utilities\BTree\BTree;
use App\Utilities\LinkedList;
use Illuminate\Database\Eloquent\Builder;

class TrainQueryBuilder extends Builder
{
    public function filterSeatsByPriceBTree($minPrice, $maxPrice): self
    {
        $trains = $this->with(['trainSchedule', 'carriages.seats.ticketPrices'])->get();

        $bTree = new BTree(3); // degree = 3

        foreach ($trains as $train) {
            foreach ($train->carriages as $carriage) {
                foreach ($carriage->seats as $seat) {
                    foreach ($train->trainSchedule as $schedule) {
                        $ticketPrice = $seat->ticketPrices
                            ->where('train_schedule_id', $schedule->id)
                            ->first();

                        if ($ticketPrice) {
                            $seatData = [
                                'seat' => $seat,
                                'carriage' => $carriage,
                                'train' => $train,
                                'schedule' => $schedule,
                                'price' => $ticketPrice->price
                            ];
                            $bTree->insert($ticketPrice->price, $seatData);
                        }
                    }
                }
            }
        }

        $filteredSeats = $bTree->searchRange($minPrice, $maxPrice);

        $trainIds = collect($filteredSeats)
            ->pluck('train.id')
            ->unique()
            ->values()
            ->all();

        // Уточняем имя таблицы для колонки id
        return $this->whereIn('trains.id', $trainIds);
    }

    public function filterSeatsByPriceBinaryTree($minPrice, $maxPrice): self
    {
        $trains = $this->with(['trainSchedule', 'carriages.seats.ticketPrices'])->get();

        $filteredTrains = $trains->filter(function ($train) use ($minPrice, $maxPrice) {
            foreach ($train->carriages as $carriage) {
                foreach ($carriage->seats as $seat) {
                    foreach ($seat->ticketPrices as $ticketPrice) {
                        if ($ticketPrice->price >= $minPrice && $ticketPrice->price <= $maxPrice) {
                            return true;
                        }
                    }
                }
            }
            return false;
        });

        $trainIds = $filteredTrains->pluck('id')->toArray();
        // Уточняем имя таблицы для колонки id
        return $this->whereIn('trains.id', $trainIds);
    }

    public function filterByRoute($from, $to): self
    {
        if ($from) {
            $this->where('from', 'like', '%'.$from.'%');
        }

        if ($to) {
            $this->where('to', 'like', '%'.$to.'%');
        }

        return $this;
    }

    public function filterByDate($date): self
    {
        if ($date) {
            return $this->whereHas('trainSchedule', function ($query) use ($date) {
                $query->whereDate('departure', $date);
            });
        }
        return $this;
    }

    public function filterSeatsByPriceLinkedList($minPrice, $maxPrice): self
    {
        $trains = $this->with(['trainSchedule', 'carriages.seats.ticketPrices'])->get();

        $trainList = new LinkedList;
        foreach ($trains as $train) {
            $trainList->add($train);
        }

        $filteredTrains = [];
        $currentTrain = $trainList->getHead();

        while ($currentTrain !== null) {
            $train = $currentTrain->data;

            $carriageList = new LinkedList;
            foreach ($train->carriages as $carriage) {
                $carriageList->add($carriage);
            }

            $currentCarriage = $carriageList->getHead();
            $trainHasMatchingSeat = false;

            while ($currentCarriage !== null && !$trainHasMatchingSeat) {
                $carriage = $currentCarriage->data;

                $seatList = new LinkedList;
                foreach ($carriage->seats as $seat) {
                    $seatList->add($seat);
                }

                $currentSeat = $seatList->getHead();
                while ($currentSeat !== null && !$trainHasMatchingSeat) {
                    $seat = $currentSeat->data;

                    foreach ($seat->ticketPrices as $ticketPrice) {
                        if ($ticketPrice->price >= $minPrice && $ticketPrice->price <= $maxPrice) {
                            $filteredTrains[] = $train->id;
                            $trainHasMatchingSeat = true;
                            break;
                        }
                    }

                    $currentSeat = $currentSeat->next;
                }

                $currentCarriage = $currentCarriage->next;
            }

            $currentTrain = $currentTrain->next;
        }

        // Уточняем имя таблицы для колонки id
        return $this->whereIn('trains.id', array_unique($filteredTrains));
    }

    public function filter(): self
    {
        $query = $this;

        $minPriceB = request('min_price_b');
        $maxPriceB = request('max_price_b');

        if ($minPriceB !== null && $maxPriceB !== null) {
            $query = $query->filterSeatsByPriceBTree($minPriceB, $maxPriceB);
        }

        $minPriceBinary = request('min_price_binary');
        $maxPriceBinary = request('max_price_binary');

        if ($minPriceBinary !== null && $maxPriceBinary !== null) {
            $query = $query->filterSeatsByPriceBinaryTree($minPriceBinary, $maxPriceBinary);
        }

        $minPriceLinked = request('min_price_linked');
        $maxPriceLinked = request('max_price_linked');

        if ($minPriceLinked !== null && $maxPriceLinked !== null) {
            $query = $query->filterSeatsByPriceLinkedList($minPriceLinked, $maxPriceLinked);
        }

        $from = request('from');
        $to = request('to');

        if ($from || $to) {
            $query = $query->filterByRoute($from, $to);
        }

        $date = request('date');

        if ($date !== null) {
            $query = $query->filterByDate($date);
        }

        return $query;
    }
}
