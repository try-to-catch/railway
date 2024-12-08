<?php

use App\Http\Controllers\CarriageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\TrainController;
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
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(SeatController::class)->group(
    function () {
        Route::get('/carriages/{carriage}/seats', [SeatController::class, 'index'])->name('carriages.seats.index');
        Route::get('/carriages/{carriage}/seats/create', [SeatController::class, 'create'])->name('carriages.seats.create');
        Route::post('/carriages/{carriage}/seats', [SeatController::class, 'store'])->name('carriages.seats.store');
        Route::get('/seats/{seat}', [SeatController::class, 'show'])->name('carriages.seats.show');
        Route::get('/seats/{seat}/edit', [SeatController::class, 'edit'])->name('carriages.seats.edit');
        Route::put('/seats/{seat}', [SeatController::class, 'update'])->name('carriages.seats.update');
        Route::delete('/seats/{seat}', [SeatController::class, 'destroy'])->name('carriages.seats.destroy');

        Route::get('/seats', [SeatController::class, 'all'])->name('seats.index');
    }
);

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
