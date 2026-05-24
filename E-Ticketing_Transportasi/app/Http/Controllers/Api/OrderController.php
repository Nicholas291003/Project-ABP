<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function buatPesanan(Request $request)
    {
        // 1. Validasi input dari Flutter (hanya butuh ID Jadwal)
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
        ]);

        $jadwal = Schedule::find($request->schedule_id);

        // 2. Cek apakah kursi masih ada
        if ($jadwal->remaining_seats < 1) {
            return response()->json([
                'status' => 'gagal',
                'pesan'  => 'Maaf, tiket untuk jadwal ini sudah habis.'
            ], 400);
        }

        // 3. Gunakan Database Transaction agar aman
        // Jika salah satu gagal (misal gagal simpan order), sisa kursi tidak jadi terpotong
        DB::beginTransaction();
        try {
            // A. Kurangi sisa kursi di tabel schedules
            $jadwal->remaining_seats -= 1;
            $jadwal->save();

            // B. Catat transaksi ke tabel orders
            $order = Order::create([
                'user_id'      => $request->user()->id, 
                'schedule_id'  => $jadwal->id,
                'order_code'   => 'TK-' . strtoupper(Str::random(6)), // Kode unik untuk tiket
                'total_passengers' => 1, // Asumsi 1 penumpang per order untuk sekarang
                'total_price'  => $jadwal->price,
                'status'       => 'pending',
            ]);

            DB::commit();

            return response()->json([
                'status' => 'sukses',
                'pesan'  => 'Pesanan berhasil dibuat!',
                'data'   => $order
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'gagal',
                'pesan'  => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    public function riwayat(Request $request)
    {
        // Tarik pesanan milik user yang sedang login, beserta detail jadwalnya
        $riwayatPesanan = Order::with(['schedule.route', 'schedule.transportation'])
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc') // Urutkan dari pesanan terbaru
            ->get();

        return response()->json([
            'status' => 'sukses',
            'data'   => $riwayatPesanan
        ], 200);
    }

    public function bayar(Request $request, $id)
    {
        // Cari pesanan berdasarkan ID dan pastikan itu milik user yang sedang login
        $order = Order::where('id', $id)->where('user_id', $request->user()->id)->first();

        if (!$order) {
            return response()->json(['status' => 'gagal', 'pesan' => 'Pesanan tidak ditemukan'], 404);
        }

        if ($order->status == 'lunas' || $order->status == 'sukses') {
            return response()->json(['status' => 'gagal', 'pesan' => 'Pesanan ini sudah dibayar'], 400);
        }

        // Ubah status menjadi lunas
        $order->status = 'lunas';
        $order->save();

        return response()->json([
            'status' => 'sukses',
            'pesan'  => 'Pembayaran berhasil diverifikasi!'
        ], 200);
    }
}