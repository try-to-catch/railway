<?php

namespace App\Http\Controllers;

use App\Http\Requests\Seat\ReserveSeatRequest;
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

    public const showRelations = ['carriage.train', 'ticketPrices.trainSchedule'];

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
        $scheduleId = request('schedule_id');

        $seats = $carriage->seats()
            ->with(self::relations)
            ->when($scheduleId, function ($query) use ($scheduleId) {
                return $query->with(['ticketPrices' => function ($query) use ($scheduleId) {
                    $query->where('train_schedule_id', $scheduleId);
                }]);
            })
            ->where('number', 'like', "%$search%")
            ->paginate(100);

        // Добавляем цены к местам
        if ($scheduleId) {
            $seats->getCollection()->transform(function ($seat) {
                $seat->price = $seat->ticketPrices->first() ? $seat->ticketPrices->first()->price : null;
                return $seat;
            });
        }

        return Inertia::render('Seats/Index', [
            'seats' => $seats,
            'carriage' => $carriage,
            'schedule_id' => $scheduleId,
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
            'seat' => $seat->load(self::showRelations),
        ]);
    }

    public function edit(Seat $seat): Response
    {
        return Inertia::render('Seats/Edit', [
            'seat' => $seat->load(self::relations),
            'carriages' => Carriage::all(),
            'user' => auth()->user(),
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

    public function reserve(ReserveSeatRequest $request, Seat $seat): RedirectResponse
    {
        $validated = $request->validated();

        if (!isset($validated['train_schedule_id'])) {
            $validated['train_schedule_id'] = request('schedule_id');
        }

        $ticketPrice = $seat->ticketPrices()
            ->where('train_schedule_id', $validated['train_schedule_id'])
            ->first();

        if (!$ticketPrice) {
            session()?->flash('error', 'No price was found for this location or schedule');
            return back();
        }

        $seat->update([
            'reserved_by_id' => auth()->id(),
            'is_reserved' => true,
        ]);

        session()?->flash('message', 'The place has been successfully booked. Cost: '.$ticketPrice->price);

        return redirect()->route('dashboard');
    }
}
