<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketPrice\StoreTicketPriceRequest;
use App\Http\Requests\TicketPrice\UpdateTicketPriceRequest;
use App\Models\TicketPrice;
use App\Models\TrainSchedule;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TicketPriceController extends Controller
{
    public function index(TrainSchedule $trainSchedule): Response
    {
        return Inertia::render('TicketPrices/Index', [
            'ticketPrices' => $trainSchedule->ticketPrices()
                ->with(['seat.carriage'])
                ->paginate(100),
            'trainSchedule' => $trainSchedule->load('train'),
        ]);
    }

    public function create(TrainSchedule $trainSchedule): Response
    {
        $train = $trainSchedule->train;
        $seats = collect();

        foreach ($train->carriages as $carriage) {
            $seats = $seats->merge($carriage->seats);
        }

        return Inertia::render('TicketPrices/Create', [
            'trainSchedule' => $trainSchedule,
            'seats' => $seats,
        ]);
    }

    public function store(StoreTicketPriceRequest $request, TrainSchedule $trainSchedule): RedirectResponse
    {
        $validated = $request->validated();

        $trainSchedule->ticketPrices()->create($validated);

        session()?->flash('message', 'Ticket price successfully added!');

        return redirect()->route('train-schedules.ticket-prices.index', $trainSchedule);
    }

    public function edit(TicketPrice $ticketPrice): Response
    {
        return Inertia::render('TicketPrices/Edit', [
            'ticketPrice' => $ticketPrice->load(['seat', 'trainSchedule.train']),
        ]);
    }

    public function update(UpdateTicketPriceRequest $request, TicketPrice $ticketPrice): RedirectResponse
    {
        $validated = $request->validated();

        $ticketPrice->update($validated);

        session()?->flash('message', 'Ticket price successfully updated!');

        return redirect()->route('train-schedules.ticket-prices.index', $ticketPrice->trainSchedule);
    }

    public function destroy(TicketPrice $ticketPrice): RedirectResponse
    {
        $trainSchedule = $ticketPrice->trainSchedule;
        $ticketPrice->delete();

        session()?->flash('message', 'Ticket price successfully removed!');

        return redirect()->route('train-schedules.ticket-prices.index', $trainSchedule);
    }
}
