<?php

namespace App\Models;

use App\Support\QueryBuilders\TrainQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static Train|TrainQueryBuilder query()
 */
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

    public function newEloquentBuilder($query): TrainQueryBuilder
    {
        return new TrainQueryBuilder($query);
    }

    public function carriages(): HasMany
    {
        return $this->hasMany(Carriage::class);
    }
}
