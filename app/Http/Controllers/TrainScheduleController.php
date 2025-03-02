<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrainSchedule\StoreTrainScheduleRequest;
use App\Models\Train;
use App\Models\TrainSchedule;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TrainScheduleController extends Controller
{
    public function index(Train $train): Response
    {
        return Inertia::render('TrainSchedules/Index', [
            'trainSchedules' => $train->trainSchedule()->paginate(10),
            'train' => $train,
        ]);
    }

    public function create(Train $train): Response
    {
        return Inertia::render('TrainSchedules/Create', [
            'train' => $train,
        ]);
    }

    public function store(StoreTrainScheduleRequest $request, Train $train): RedirectResponse
    {
        $validated = $request->validated();

        $train->trainSchedule()->create($validated);

        session()?->flash('message', 'Schedule successfully added!');

        return redirect()->route('trains.train-schedules.index', $train);
    }

    public function show(TrainSchedule $trainSchedule): Response
    {
        return Inertia::render('TrainSchedules/Show', [
            'trainSchedule' => $trainSchedule->load('train'),
        ]);
    }
}
