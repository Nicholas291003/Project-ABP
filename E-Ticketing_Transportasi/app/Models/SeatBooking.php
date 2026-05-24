<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeatBooking extends Model
{
    protected $fillable = ['schedule_id', 'order_id', 'coach_name', 'seat_number'];

    public function seatBookings() {
        return $this->hasMany(SeatBooking::class);
    }
}

