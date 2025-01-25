<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Train extends Model
{
    /** @use HasFactory<\Database\Factories\TrainFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'from',
        'to',
        'departure',
        'arrival',
    ];

    public function carriages(): HasMany
    {
        return $this->hasMany(Carriage::class);
    }
}
