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

    /**
     * Display a listing of the resource.
     */
    public function index(Train $train): Response
    {
        return Inertia::render('Carriages/Index', [
            'carriages' => $train->carriages()->with(self::RELATIONS)->paginate(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Carriages/Create', [
            'trains' => Train::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarriageRequest $request, Train $train): RedirectResponse
    {
        $carriage = $train->carriages()->create($request->validated());

        session()?->flash('message', 'Carriage created successfully!');

        return redirect()->route('carriages.show', [$train, $carriage]);
    }

    /**
     * Display the specified resource.
     */
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

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarriageRequest $request, Carriage $carriage): RedirectResponse
    {
        $carriage->update($request->validated());

        session()?->flash('message', 'Carriage updated successfully!');

        return redirect()->route('carriages.show', $carriage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carriage $carriage): RedirectResponse
    {
        $carriage->delete();

        session()?->flash('message', 'Carriage deleted successfully!');

        return redirect()->route('carriages.index');
    }
}
