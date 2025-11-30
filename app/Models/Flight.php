<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'flight_code',
        'airline',
        'from_airport_id',
        'to_airport_id',
        'departure_time',
        'arrival_time',
        'price',
        'seat_class',
        'status',
    ];

    protected $casts = [
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
        'price' => 'decimal:2',
    ];

    /**
     * Get the departure airport
     */
    public function fromAirport()
    {
        return $this->belongsTo(Airport::class, 'from_airport_id');
    }

    /**
     * Get the arrival airport
     */
    public function toAirport()
    {
        return $this->belongsTo(Airport::class, 'to_airport_id');
    }

    /**
     * Get flight bookings
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Scope for active flights only
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
