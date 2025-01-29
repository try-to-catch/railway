<?php

namespace App\Http\Controllers;

use App\Models\Train;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TrainScheduleController extends Controller
{
    public function create(Train $train): Response
    {
        return Inertia::render('TrainSchedules/Create', [
            'train' => $train,
        ]);
    }

    public function store(Request $request, Train $train): RedirectResponse
    {
        $train->trainSchedule()->create($request->all());

        return redirect()->route('trains.index', $train);
    }
}
