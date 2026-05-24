<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_id', 
        'transportation_id',
        'departure_date', 
        'departure_time', 
        'arrival_time', 
        'price', 
        'total_seats', 
        'remaining_seats'
    ];

    // Relasi balik ke Route (Satu jadwal memiliki satu rute tetap)
    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    // Relasi balik ke Transportation (Satu jadwal memiliki satu armada)
    public function transportation()
    {
        return $this->belongsTo(Transportation::class);
    }
}