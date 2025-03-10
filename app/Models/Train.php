<?php

namespace App\Models;

use App\Support\QueryBuilders\TrainQueryBuilder;
use Carbon\Carbon;
use Database\Factories\TrainFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static Train|TrainQueryBuilder query()
 */
class Train extends Model
{
    /** @use HasFactory<TrainFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'from',
        'to',
    ];

    public function newEloquentBuilder($query): TrainQueryBuilder
    {
        return new TrainQueryBuilder($query);
    }

    public function carriages(): HasMany
    {
        return $this->hasMany(Carriage::class);
    }

    public function trainSchedule(): HasMany
    {
        return $this->hasMany(TrainSchedule::class);
    }

    public function getDepartureAttribute($attribute): string
    {
        return Carbon::parse($attribute)->format('d M | H:i');
    }

    public function getArrivalAttribute($attribute): string
    {
        return Carbon::parse($attribute)->format('d M | H:i');
    }
}
