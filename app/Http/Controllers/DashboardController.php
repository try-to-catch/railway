<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = auth()->user();
        $isAdmin = $user->isAdmin();

        $query = Reservation::with([
            'seat.carriage.train',
            'trainSchedule',
            'seat.ticketPrices',
            'user'
        ]);

        if (!$isAdmin) {
            $query->where('user_id', $user->id);
        }

        $reservations = $query->get()->map(function ($reservation) {
            $reservation->price = $reservation->seat->ticketPrices
                ->where('train_schedule_id', $reservation->train_schedule_id)
                ->first()?->price;
            return $reservation;
        });

        return Inertia::render('Dashboard', [
            'reservations' => $reservations,
            'isAdmin' => $isAdmin,
        ]);
    }
}
