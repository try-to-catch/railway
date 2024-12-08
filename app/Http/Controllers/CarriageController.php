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

    /**
     * Display a listing of the resource.
     */
    public function index(Train $train)
    {
        return Inertia::render('Carriages/Index', [
            'carriages' => $train->carriages()->with(self::RELATIONS)->paginate(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Carriages/Create', [
            'trains' => Train::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarriageRequest $request, Train $train)
    {
        $carriage = $train->carriages()->create($request->validated());

        session()->flash('message', 'Carriage created successfully!');

        return redirect()->route('carriages.show', [$train, $carriage]);
    }

    /**
     * Display the specified resource.
     */
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

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarriageRequest $request, Carriage $carriage)
    {
        $carriage->update($request->validated());

        session()->flash('message', 'Carriage updated successfully!');

        return redirect()->route('carriages.show', $carriage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carriage $carriage)
    {
        $carriage->delete();

        session()->flash('message', 'Carriage deleted successfully!');

        return redirect()->route('carriages.index');
    }
}
