<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Admin\TransportationController;
use App\Models\Schedule;
use App\Models\TransitPoint;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_rute',
        'transportation_id',
        'kota_asal', 
        'simpul_asal', 
        'kota_tujuan', 
        'simpul_tujuan', 
        'jarak', 
        'estimasi_jam', 
        'estimasi_menit', 
        'tarif_dasar'
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function transitPoints()
    {
        return $this->hasMany(TransitPoint::class)->orderBy('stop_order', 'asc');
    }
}