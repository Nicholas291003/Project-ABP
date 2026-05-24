<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Route;

class Transportation extends Model
{
    use HasFactory;

    protected $fillable = ['kode', 'nama', 'jenis', 'kelas', 'jumlah_kursi', 'status', 'fasilitas'];

    // Relasi: Satu kendaraan bisa memiliki banyak rute/jadwal
    public function routes()
    {
        return $this->hasMany(Route::class);
    }
}
