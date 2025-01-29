<?php

use App\Http\Controllers\CarriageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\TrainController;
use App\Http\Controllers\TrainScheduleController;
use App\Models\Seat;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', static function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', static function () {
    return Inertia::render('Dashboard', [
        'seats' => Seat::with('carriage.train')
            ->where('reserved_by_id', auth()->id())
        ->get(),
    ]);
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::controller(SeatController::class)->group(function () {
        Route::get('/carriages/{carriage}/seats', 'index')->name('carriages.seats.index');
        Route::get('/carriages/{carriage}/seats/create', 'create')->name('carriages.seats.create');
        Route::post('/carriages/{carriage}/seats', 'store')->name('carriages.seats.store');
        Route::get('/seats/{seat}', 'show')->name('carriages.seats.show');
        Route::get('/seats/{seat}/edit', 'edit')->name('carriages.seats.edit');
        Route::put('/seats/{seat}', 'update')->name('carriages.seats.update');
        Route::delete('/seats/{seat}', 'destroy')->name('carriages.seats.destroy');
        Route::post('/seats/{seat}/reserve', 'reserve')->name('seats.reserve');
        Route::get('/seats', 'all')->name('seats.index');
    });
});

Route::controller(CarriageController::class)->group(
    function () {
        Route::get('/trains/{train}/carriages', [CarriageController::class, 'index'])->name('trains.carriages.index');
        Route::get('/trains/{train}/carriages/create', [CarriageController::class, 'create'])->name('trains.carriages.create');
        Route::post('/trains/{train}/carriages', [CarriageController::class, 'store'])->name('trains.carriages.store');
        Route::get('carriages/{carriage}', [CarriageController::class, 'show'])->name('trains.carriages.show');
        Route::get('carriages/{carriage}/edit', [CarriageController::class, 'edit'])->name('trains.carriages.edit');
        Route::put('carriages/{carriage}', [CarriageController::class, 'update'])->name('trains.carriages.update');
        Route::delete('carriages/{carriage}', [CarriageController::class, 'destroy'])->name('trains.carriages.destroy');
    }
);

Route::controller(TrainScheduleController::class)->group(
    function () {
        Route::get('/trains/{train}/trips/create', 'create')->name('trains.trips.create');
        Route::post('/trains/{train}/trips', 'store')->name('trains.trips.store');
    }
);


Route::controller(TrainController::class)->group(
    function () {
        Route::get('/trains', [TrainController::class, 'index'])->name('trains.index');
        Route::post('/trains', [TrainController::class, 'store'])->name('trains.store');
        Route::get('/trains/create', [TrainController::class, 'create'])->name('trains.create');
        Route::get('/trains/{train}', [TrainController::class, 'show'])->name('trains.show');
        Route::get('/trains/{train}/edit', [TrainController::class, 'edit'])->name('trains.edit');
        Route::put('/trains/{train}', [TrainController::class, 'update'])->name('trains.update');
        Route::delete('/trains/{train}', [TrainController::class, 'destroy'])->name('trains.destroy');
    }
);

require __DIR__.'/auth.php';
