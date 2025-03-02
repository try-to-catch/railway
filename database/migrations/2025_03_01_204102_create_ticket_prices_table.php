<?php

use App\Models\Seat;
use App\Models\TrainSchedule;
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
        Schema::create('ticket_prices', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Seat::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(TrainSchedule::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedInteger('price');

            $table->timestamps();

            $table->unique(['seat_id', 'train_schedule_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_prices');
    }
};
