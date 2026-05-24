<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'schedule_id', 
        'order_code', 
        'total_passengers', 
        'total_price', 
        'status'
    ];

    /**
     * Relasi ke User (Penumpang)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function seatBookings()
    {
        return $this->hasMany(SeatBooking::class);
    }

    /**
     * Relasi ke Jadwal
     */
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }
}