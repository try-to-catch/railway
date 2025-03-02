<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'carriage_id',
    ];

    protected $appends = ['is_reserved_for_schedule'];

    protected $casts = [
        'is_reserved_for_schedule' => 'boolean',
    ];

    public function carriage(): BelongsTo
    {
        return $this->belongsTo(Carriage::class);
    }

    public function reservedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reserved_by_id');
    }

    public function ticketPrices(): HasMany
    {
        return $this->hasMany(TicketPrice::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function isReservedForSchedule($scheduleId): bool
    {
        return $this->reservations()
            ->where('train_schedule_id', $scheduleId)
            ->exists();
    }

    public function getIsReservedForScheduleAttribute(): bool
    {
        $scheduleId = request('schedule_id');

        if (!$scheduleId) {
            return false;
        }

        return $this->isReservedForSchedule($scheduleId);
    }

    public function getReservedByForSchedule($scheduleId)
    {
        $reservation = $this->reservations()
            ->where('train_schedule_id', $scheduleId)
            ->with('user')
            ->first();

        return $reservation ? $reservation->user : null;
    }
}
