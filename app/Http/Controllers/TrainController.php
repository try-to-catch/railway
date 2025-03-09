<?php

namespace App\Http\Controllers;

use App\Http\Requests\Train\StoreTrainRequest;
use App\Http\Requests\Train\UpdateTrainRequest;
use App\Models\Carriage;
use App\Models\Seat;
use App\Models\Train;
use App\Models\TrainSchedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class TrainController extends Controller
{
    public const RELATIONS = ['carriages'];

    /* Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Trains/Index', [
            'trains' => Train::query()
                ->join('train_schedules', 'trains.id', '=', 'train_schedules.train_id')
                ->select('trains.*', 'train_schedules.id as schedule_id', 'train_schedules.departure', 'train_schedules.arrival')
                ->filter()
                ->paginate(100),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Trains/Create');
    }

    /**
     * @throws Throwable
     */
    public function store(StoreTrainRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $train = Train::query()->create([
                'name' => $request->name,
                'from' => $request->from,
                'to' => $request->to,
            ]);

            $schedule = $train->trainSchedule()->create([
                'departure' => $request->departure,
                'arrival' => $request->arrival,
            ]);

            $carriageClasses = ['Economy', 'Economy', 'Standard', 'Standard', 'Business'];

            for ($carriageNumber = 1; $carriageNumber <= 5; $carriageNumber++) {
                $carriage = $train->carriages()->create([
                    'number' => $carriageNumber,
                    'class' => $carriageClasses[$carriageNumber - 1],
                ]);

                $basePrice = match($carriageClasses[$carriageNumber - 1]) {
                    'Economy' => 500,
                    'Standard' => 1000,
                    'Business' => 2000,
                    default => 800,
                };

                for ($seatNumber = 1; $seatNumber <= 20; $seatNumber++) {
                    $seat = $carriage->seats()->create([
                        'number' => $carriageNumber . '-' . $seatNumber,
                    ]);

                    $seat->ticketPrices()->create([
                        'train_schedule_id' => $schedule->id,
                        'price' => random_int($basePrice, $basePrice * 1.5)
                    ]);
                }
            }
        });

        session()?->flash('message', 'Поезд успешно создан с 5 вагонами и 100 местами!');

        return redirect()->route('trains.index');
    }

    /* Display the specified resource.
     */
    public function show(Train $train): Response
    {
        return Inertia::render('Trains/Show', [
            'train' => $train->load(self::RELATIONS),
        ]);
    }

    public function edit(Train $train): Response
    {
        return Inertia::render('Trains/Edit', [
            'train' => $train->load(['carriages', 'trainSchedule']),
        ]);
    }

    /* Update the specified resource in storage.
     */
    public function update(UpdateTrainRequest $request, Train $train): RedirectResponse
    {
        $train->update($request->only(['name', 'from', 'to']));

        $train->trainSchedule()->update([
            'departure' => $request->departure,
            'arrival' => $request->arrival,
        ]);

        session()?->flash('message', 'Train updated successfully!');

        return redirect()->route('trains.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Train $train): RedirectResponse
    {
        $train->delete();

        session()?->flash('message', 'Train deleted successfully!');

        return redirect()->route('trains.index');
    }
}
