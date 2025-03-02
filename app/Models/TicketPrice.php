<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketPrice extends Model
{
    /** @use HasFactory<\Database\Factories\TicketPriceFactory> */
    use HasFactory;

    protected $fillable = [
        'seat_id',
        'train_schedule_id',
        'price',
    ];

    public function seat(): BelongsTo
    {
        return $this->belongsTo(Seat::class);
    }

    public function trainSchedule(): BelongsTo
    {
        return $this->belongsTo(TrainSchedule::class);
    }
}
