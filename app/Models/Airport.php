<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'city',
        'country',
    ];

    /**
     * Get flights departing from this airport
     */
    public function departures()
    {
        return $this->hasMany(Flight::class, 'from_airport_id');
    }

    /**
     * Get flights arriving to this airport
     */
    public function arrivals()
    {
        return $this->hasMany(Flight::class, 'to_airport_id');
    }
}
