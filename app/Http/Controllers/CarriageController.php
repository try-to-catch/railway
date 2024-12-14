<?php

namespace App\Http\Controllers;

use App\Http\Requests\Carriage\StoreCarriageRequest;
use App\Http\Requests\Carriage\UpdateCarriageRequest;
use App\Models\Carriage;
use App\Models\Train;
use Inertia\Inertia;

class CarriageController extends Controller
{
    const RELATIONS = ['seats', 'train'];


    public function index(Train $train)
    {
        return Inertia::render('Carriages/Index', [
            'carriages' => $train->carriages()->with(self::RELATIONS)->paginate(),
            'train' => $train,
        ]);
    }

    public function create(Train $train)
    {
        return Inertia::render('Carriages/Create', [
            'trains' => Train::all(),
            'train' => $train,
        ]);
    }

    public function store(StoreCarriageRequest $request, Train $train)
    {
        $train->carriages()->create($request->validated());

        session()->flash('message', 'Carriage created successfully!');

        return redirect()->route('trains.carriages.index', [$train]);
    }


    public function show(Carriage $carriage)
    {
        return Inertia::render('Carriages/Show', [
            'carriage' => $carriage->load(self::RELATIONS),
        ]);
    }

    public function edit(Carriage $carriage)
    {
        return Inertia::render('Carriages/Edit', [
            'carriage' => $carriage->load(self::RELATIONS),
            'trains' => Train::all(),
        ]);
    }

    public function update(UpdateCarriageRequest $request, Carriage $carriage)
    {
        $carriage->update($request->validated());

        session()->flash('message', 'Carriage updated successfully!');

        return redirect()->route('trains.carriages.index', $carriage->train()->first());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carriage $carriage)
    {
        $carriage->delete();

        session()->flash('message', 'Carriage deleted successfully!');

        return redirect()->route('trains.carriages.index');
    }
}
