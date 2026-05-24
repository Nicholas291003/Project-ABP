<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Route;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Mengambil data statistik untuk Stat Cards
        $totalTiketTerjual = Order::where('status', 'lunas')->sum('total_passengers');
        $totalPendapatan = Order::where('status', 'lunas')->sum('total_price');
        $totalPenumpang = User::where('role', 'penumpang')->count();
        $totalRute = Route::count();

        // 2. Mengambil 4 pesanan terbaru beserta data relasinya (Eager Loading)
        $pesananTerbaru = Order::with(['user', 'schedule.route','schedule.transportation'])
                                ->latest()
                                ->take(4)
                                ->get();

        // 3.Mengambil 3 kelompok jadwal secara spesifik dan real-time bedasarkan waktu nyata dan 
        // mengambil 3 jadwal terdekat hari ini, 3 jadwal mendatang, dan 3 jadwal terlewat.
        $todayStr = Carbon::today()->toDateString();
        $jadwalHariIni = Schedule::with(['route', 'transportation'])
                            ->where('departure_date', $todayStr)
                            ->orderBy('departure_time', 'asc')
                            ->take(3)
                            ->get();
        $jadwalMendatang = Schedule::with(['route', 'transportation'])
                            ->where('departure_date', '>', $todayStr)
                            ->orderBy('departure_date', 'asc')
                            ->orderBy('departure_time', 'asc')
                            ->take(3)
                            ->get();
        $jadwalTerlewat = Schedule::with(['route', 'transportation'])
                            ->where('departure_date', '<', $todayStr)
                            ->orderBy('departure_date', 'desc')
                            ->orderBy('departure_time', 'desc')
                            ->take(3)
                            ->get();

        // Kirim semua variabel ke view admin
        return view('admin.dashboard', compact(
            'totalTiketTerjual', 
            'totalPendapatan', 
            'totalPenumpang', 
            'totalRute', 
            'pesananTerbaru',
            'jadwalHariIni',
            'jadwalMendatang',
            'jadwalTerlewat'
        ));
    }
}