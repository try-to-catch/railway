<?php

use App\Models\Seat;
use App\Models\TrainSchedule;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(Seat::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(TrainSchedule::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['seat_id', 'train_schedule_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
