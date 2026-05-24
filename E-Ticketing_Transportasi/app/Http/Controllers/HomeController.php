<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;

class HomeController extends Controller
{
    // 1. Menampilkan Halaman Depan dengan Algoritma Jadwal Terlaris Realtime
    public function index()
    {
        // 💡 CERDAS: Menghitung selisih kursi (total_seats - remaining_seats) sebagai 'sold_seats' 
        // Lalu diurutkan dari yang paling banyak terjual (terlaris) untuk jadwal mendatang
        $rutePopuler = Schedule::with(['route', 'transportation'])
            ->where('departure_date', '>=', date('Y-m-d'))
            ->selectRaw('*, (total_seats - remaining_seats) as sold_seats')
            ->orderBy('sold_seats', 'desc')
            ->orderBy('departure_date', 'asc')
            ->take(4)
            ->get();

        return view('welcome', compact('rutePopuler'));
    }

    // 2. Memproses Live Search Pencarian Tiket dari Form Depan
    // 2. Memproses Live Search Pencarian Tiket dari Form Depan
    public function search(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:kereta,bus,pesawat',
            'from'  => 'required|string',
            'to    '  => 'required|string',
            'date'  => 'required|date',
        ]);

        $asal = $request->from;
        $tujuan = $request->to;
        $jenis = strtolower($request->jenis); // Pastikan jenis dalam huruf kecil untuk pencocokan yang konsisten

        $hasilPencarian = Schedule::with(['route', 'transportation'])
            ->whereDate('departure_date', $request->date)
            ->whereHas('transportation', function ($q) use ($jenis) {
                $q->whereRaw('LOWER(jenis) = ?', [$jenis])
                  ->where('status', 'aktif');
            })
            ->whereHas('route', function ($q) use ($asal, $tujuan) {
                $q->where('kota_asal', 'LIKE', '%' . $asal . '%')
                  ->where('kota_tujuan', 'LIKE', '%' . $tujuan . '%');
            })
            ->orderBy('departure_time', 'asc')
            ->get();

        $rutePopuler = Schedule::with(['route', 'transportation'])
            ->where('departure_date', '>=', date('Y-m-d'))
            ->selectRaw('*, (total_seats - remaining_seats) as sold_seats')
            ->orderBy('sold_seats', 'desc')
            ->take(4)
            ->get();

        return view('welcome', [
            'pencarianSelesai' => true,
            'hasilPencarian' => $hasilPencarian,
            'rutePopuler' => $rutePopuler,
            'paramAsal' => $request->from,
            'paramTujuan' => $request->to,
            'paramTanggal' => $request->date,
            'paramJenis' => $request->jenis
        ]);
    }
}