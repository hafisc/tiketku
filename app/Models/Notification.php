<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'to_phone',
        'message',
        'status',
        'response_payload',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    /**
     * Get the booking associated with this notification
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
