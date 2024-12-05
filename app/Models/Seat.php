<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Seat extends Model
{
    /** @use HasFactory<\Database\Factories\SeatFactory> */
    use HasFactory;

    protected $fillable = [
        'number',
        'is_reserved',
    ];

    public function carriage(): BelongsTo
    {
        return $this->belongsTo(Carriage::class);
    }
}