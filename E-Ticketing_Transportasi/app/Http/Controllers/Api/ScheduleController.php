<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function rutePopuler()
    {
        $jadwalPopuler = Schedule::with(['route', 'transportation'])
            ->whereDate('departure_date', '>=', now()->toDateString())
            ->whereHas('transportation', function ($q) {
                $q->where('status', 'aktif'); // Memastikan armada tidak sedang maintenance
            })
            ->selectRaw('*, (total_seats - remaining_seats) as sold_seats')
            ->orderBy('sold_seats', 'desc')
            ->take(5) // Ambil 5 rute teratas
            ->get();

        // Mengembalikan data dalam bentuk JSON
        return response()->json([
            'status' => 'sukses',
            'pesan'  => 'Data rute populer berhasil ditarik',
            'data'   => $jadwalPopuler
        ], 200);
    }

    public function ruteTransit($route_id)
    {
        // Mencari rute berdasarkan ID dan langsung menarik relasi titik transitnya
        $rute = \App\Models\Route::with('transitPoints')->find($route_id);

        if (!$rute) {
            return response()->json([
                'status' => 'gagal',
                'pesan'  => 'Data rute tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'sukses',
            'pesan'  => 'Data titik transit berhasil ditarik',
            'data'   => $rute
        ], 200);
    }

    public function search(Request $request)
    {
        // Menangkap data pencarian yang dikirim dari Flutter
        $asal = $request->query('asal');
        $tujuan = $request->query('tujuan');
        $tanggal = $request->query('tanggal');

        // Validasi dasar, pastikan 3 data utama ini terisi
        if (!$asal || !$tujuan || !$tanggal) {
            return response()->json([
                'status' => 'gagal',
                'pesan'  => 'Kota asal, tujuan, dan tanggal wajib diisi!'
            ], 400);
        }

        // Mencari jadwal yang cocok di database
        $hasilPencarian = \App\Models\Schedule::with(['route', 'transportation'])
            // Filter berdasarkan relasi tabel rute
            ->whereHas('route', function ($q) use ($asal, $tujuan) {
                $q->where('kota_asal', 'LIKE', "%{$asal}%")
                  ->where('kota_tujuan', 'LIKE', "%{$tujuan}%");
            })
            // Filter tanggal keberangkatan
            ->whereDate('departure_date', $tanggal)
            // Hanya tampilkan tiket yang kursinya belum habis
            ->where('remaining_seats', '>', 0)
            // Mengurutkan dari harga termurah
            ->orderBy('price', 'asc')
            ->get();

        return response()->json([
            'status' => 'sukses',
            'pesan'  => count($hasilPencarian) > 0 ? 'Tiket ditemukan' : 'Maaf, tiket tidak tersedia untuk rute dan tanggal tersebut',
            'data'   => $hasilPencarian
        ], 200);
    }
}
