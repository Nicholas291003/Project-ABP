<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Route;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        // 1. Kalkulasi Data untuk Statistik Boks (Mini Stats)
        $total_jadwal = Schedule::count();
        $jadwal_hari_ini = Schedule::where('departure_date', date('Y-m-d'))->count();
        $total_kursi_terjual = Schedule::sum('total_seats') - Schedule::sum('remaining_seats');

        // 2. Mengambil semua rute beserta kendaraan untuk opsi Dropdown di Modal
        $routes_list = Route::latest()->get();
        $transportation_list = \App\Models\Transportation::latest()->get();

        // 3. Logika Pencarian & Penyaringan Tabel Jadwal
        $query = Schedule::with(['route', 'transportation']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            
            $query->where(function($q) use ($search) {
                // Cari berdasarkan rute (kota asal / tujuan)
                $q->whereHas('route', function($qr) use ($search) {
                    $qr->where('kota_asal', 'LIKE', "%{$search}%")
                      ->orWhere('kota_tujuan', 'LIKE', "%{$search}%");
                })
                // ATAU Cari berdasarkan nama kendaraan
                ->orWhereHas('transportation', function($qt) use ($search) {
                    $qt->where('nama', 'LIKE', "%{$search}%")
                      ->orWhere('kode', 'LIKE', "%{$search}%");
                });
            });
        }

        if ($request->filled('status_waktu')) {
            $today = date('Y-m-d');
            $now = date('H:i:s');

            if ($request->status_waktu == 'upcoming') {
                $query->where(function($q) use ($today, $now) {
                    $q->where('departure_date', '>', $today)
                      ->orWhere(function($qr) use ($today, $now) {
                          $qr->where('departure_date', $today)
                             ->where('departure_time', '>', $now);
                      });
                });
            } elseif ($request->status_waktu == 'past') {
                $query->where(function($q) use ($today, $now) {
                    $q->where('departure_date', '<', $today)
                      ->orWhere(function($qr) use ($today, $now) {
                          $qr->where('departure_date', $today)
                             ->where('departure_time', '<=', $now);
                      });
                });
            }
        }

        $schedules = $query->orderBy('departure_date', 'asc')
                           ->orderBy('departure_time', 'asc')
                           ->paginate(10);

        return view('admin.schedule.index', compact(
            'schedules', 'total_jadwal', 'jadwal_hari_ini', 'total_kursi_terjual', 'routes_list', 'transportation_list'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'route_id' => 'required|exists:routes,id',
            'transportation_id' => 'required|exists:transportations,id',
            'departure_date' => 'required|date|after_or_equal:today',
            'departure_time' => 'required',
            'arrival_time' => 'required',
            'price' => 'required|integer|min:0',
            'total_seats' => 'required|integer|min:1',
        ]);

        Schedule::create([
            'route_id' => $request->route_id,
            'transportation_id' => $request->transportation_id,
            'departure_date' => $request->departure_date,
            'departure_time' => $request->departure_time,
            'arrival_time' => $request->arrival_time,
            'price' => $request->price,
            'total_seats' => $request->total_seats,
            'remaining_seats' => $request->total_seats, 
        ]);

        return redirect()->route('admin.schedule.index')->with('success', 'Jadwal keberangkatan baru berhasil diterbitkan!');
    }

    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);

        $request->validate([
            'route_id' => 'required|exists:routes,id',
            'transportation_id' => 'required|exists:transportations,id',
            'departure_date' => 'required|date',
            'departure_time' => 'required',
            'arrival_time' => 'required',
            'price' => 'required|integer|min:0',
            'total_seats' => 'required|integer|min:1',
        ]);

        $selisih_kursi = $request->total_seats - $schedule->total_seats;
        $new_remaining = $schedule->remaining_seats + $selisih_kursi;

        $schedule->update([
            'route_id' => $request->route_id,
            'transportation_id' => $request->transportation_id,
            'departure_date' => $request->departure_date,
            'departure_time' => $request->departure_time,
            'arrival_time' => $request->arrival_time,
            'price' => $request->price,
            'total_seats' => $request->total_seats,
            'remaining_seats' => max(0, $new_remaining),
        ]);

        return redirect()->route('admin.schedule.index')->with('success', 'Jadwal keberangkatan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('admin.schedule.index')->with('success', 'Jadwal berhasil dihapus dari sistem.');
    }
}