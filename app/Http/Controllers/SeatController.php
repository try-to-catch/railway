<?php

namespace App\Http\Controllers;

use App\Http\Requests\Seat\StoreSeatRequest;
use App\Http\Requests\Seat\UpdateSeatRequest;
use App\Models\Carriage;
use App\Models\Seat;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SeatController extends Controller
{
    public const relations = ['carriage'];

    public function all(): Response
    {
        return Inertia::render('Seats/All', [
            'seats' => Seat::with(self::relations)->paginate(),
        ]);
    }

    /* Display a listing of the resource.
     */
    public function index(Carriage $carriage): Response
    {
        $search = request('search');

        return Inertia::render('Seats/Index', [
            'seats' => $carriage
                ->seats()
                ->with(self::relations)
                ->where('number', 'like', "%$search%")
                ->paginate(),
        ]);
    }

    public function create(Carriage $carriage): Response
    {
        return Inertia::render('Seats/Create', [
            'carriages' => Carriage::all(),
            'carriage' => $carriage,
        ]);
    }

    /* Store a newly created resource in storage.
     */
    public function store(StoreSeatRequest $request, Carriage $carriage): RedirectResponse
    {
        $carriage->seats()->create($request->validated());

        session()?->flash('message', 'Seat created successfully!');

        return redirect()->route('carriages.seats.index', $carriage);
    }

    /* Display the specified resource.
     */
    public function show(Seat $seat): Response
    {
        return Inertia::render('Seats/Show', [
            'seat' => $seat->load(self::relations),
        ]);
    }

    public function edit(Seat $seat): Response
    {
        return Inertia::render('Seats/Edit', [
            'seat' => $seat->load(self::relations),
            'carriages' => Carriage::all(),
        ]);
    }

    /* Update the specified resource in storage.
     */
    public function update(UpdateSeatRequest $request, Seat $seat): RedirectResponse
    {
        $seat->update($request->validated());

        session()?->flash('message', 'Seat updated successfully!');

        return redirect()->route('carriages.seats.index', $seat->carriage()->first());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seat $seat): RedirectResponse
    {
        $seat->delete();

        session()?->flash('message', 'Seat deleted successfully!');

        return redirect()->route('carriages.seats.index', $seat->carriage()->first());
    }
}
