<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function cancel(Reservation $reservation): RedirectResponse
    {
        if ($reservation->user_id !== Auth::id()) {
            session()?->flash('error', 'Вы не можете отменить это бронирование');
            return redirect()->route('dashboard');
        }

        $departureDate = Carbon::parse($reservation->trainSchedule->departure);

        if ($departureDate->isPast()) {
            session()?->flash('error', 'Нельзя отменить бронирование после отправления поезда');
            return redirect()->route('dashboard');
        }

        $reservation->delete();

        session()?->flash('message', 'Бронирование успешно отменено');
        return redirect()->route('dashboard');
    }
}
