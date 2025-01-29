<?php

namespace App\Models;

use Database\Factories\TrainScheduleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainSchedule extends Model
{
    /** @use HasFactory<TrainScheduleFactory> */
    use HasFactory;

    protected $fillable = [
        'departure',
        'arrival',
    ];

    public function train(): BelongsTo
    {
        return $this->belongsTo(Train::class);
    }
}
