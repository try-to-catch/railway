<?php

namespace App\Models;

use App\Support\Casts\PriceCast;
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

    protected function casts(): array
    {
        return [
            'price' => PriceCast::class,
        ];
    }

    public function carriage(): BelongsTo
    {
        return $this->belongsTo(Carriage::class);
    }
}
