<?php

namespace App\Http\Controllers;

use App\Http\Requests\Carriage\StoreCarriageRequest;
use App\Http\Requests\Carriage\UpdateCarriageRequest;
use App\Models\Carriage;
use App\Models\Train;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CarriageController extends Controller
{
    public const RELATIONS = ['seats', 'train'];

    public function index(Train $train): Response
    {
        return Inertia::render('Carriages/Index', [
            'carriages' => $train->carriages()->with(self::RELATIONS)->paginate(100),
            'train' => $train,
        ]);
    }

    public function create(Train $train): Response
    {
        return Inertia::render('Carriages/Create', [
            'trains' => Train::all(),
            'train' => $train,
        ]);
    }

    public function store(StoreCarriageRequest $request, Train $train): RedirectResponse
    {
        $train->carriages()->create($request->validated());

        session()?->flash('message', 'Carriage created successfully!');

        return redirect()->route('trains.carriages.index', [$train]);
    }

    public function show(Carriage $carriage): Response
    {
        return Inertia::render('Carriages/Show', [
            'carriage' => $carriage->load(self::RELATIONS),
        ]);
    }

    public function edit(Carriage $carriage): Response
    {
        return Inertia::render('Carriages/Edit', [
            'carriage' => $carriage->load(self::RELATIONS),
            'trains' => Train::all(),
        ]);
    }

    public function update(UpdateCarriageRequest $request, Carriage $carriage): RedirectResponse
    {
        $carriage->update($request->validated());

        session()?->flash('message', 'Carriage updated successfully!');

        return redirect()->route('trains.carriages.index', $carriage->train()->first());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carriage $carriage): RedirectResponse
    {
        $carriage->delete();

        session()?->flash('message', 'Carriage deleted successfully!');

        return redirect()->route('trains.carriages.index');
    }
}
