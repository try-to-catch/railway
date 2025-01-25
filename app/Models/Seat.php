<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'price',
        'is_reserved',
        'carriage_id',
    ];

    public function carriage(): BelongsTo
    {
        return $this->belongsTo(Carriage::class);
    }
}
