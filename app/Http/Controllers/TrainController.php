<?php

namespace App\Http\Controllers;

use App\Http\Requests\Train\StoreTrainRequest;
use App\Http\Requests\Train\UpdateTrainRequest;
use App\Models\Train;
use Inertia\Inertia;

class TrainController extends Controller
{
    const RELATIONS = ['carriages'];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Trains/Index', [
            'trains' => Train::query()->with(self::RELATIONS)->paginate(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Trains/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTrainRequest $request)
    {
        $train = Train::create($request->validated());

        session()->flash('message', 'Train created successfully!');

        return redirect()->route('trains.show', $train);
    }

    /**
     * Display the specified resource.
     */
    public function show(Train $train)
    {
        return Inertia::render('Trains/Show', [
            'train' => $train->load(self::RELATIONS),
        ]);
    }

    public function edit(Train $train)
    {
        return Inertia::render('Trains/Edit', [
            'train' => $train->load(self::RELATIONS),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrainRequest $request, Train $train)
    {
        $train->update($request->validated());

        session()->flash('message', 'Train updated successfully!');

        return redirect()->route('trains.show', $train);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Train $train)
    {
        $train->delete();

        session()->flash('message', 'Train deleted successfully!');

        return redirect()->route('trains.index');
    }
}
