<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // 1. Hitung Data Ringkasan Statistik Transaksi
        $total_pesanan = Order::count();
        $pesanan_pending = Order::where('status', 'pending')->count();
        $total_pendapatan = Order::where('status', 'lunas')->sum('total_price');

        // 2. Query Pencarian & Filter Status Table (Menyesuaikan Relasi Baru)
        $query = Order::with(['user', 'schedule.route', 'schedule.transportation']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_code', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($uQ) use ($search) {
                      $uQ->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        $orders = $query->latest()->paginate(10);

        return view('admin.orders.index', compact(
            'orders', 'total_pesanan', 'pesanan_pending', 'total_pendapatan'
        ));
    }

    public function update(Request $request, $id)
    {
        $order = Order::with('schedule')->findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,lunas,dibatalkan',
        ]);

        $old_status = $order->status;
        $new_status = $request->status;

        // Manipulasi kuota kursi kendaraan otomatis
        if ($new_status === 'dibatalkan' && $old_status !== 'dibatalkan') {
            $order->schedule->increment('remaining_seats', $order->total_passengers);
        } elseif ($new_status !== 'dibatalkan' && $old_status === 'dibatalkan') {
            $order->schedule->decrement('remaining_seats', $order->total_passengers);
        }

        $order->update(['status' => $new_status]);

        return redirect()->route('admin.orders.index')->with('success', "Status pesanan {$order->order_code} berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        
        if ($order->status !== 'dibatalkan') {
            $order->schedule->increment('remaining_seats', $order->total_passengers);
        }

        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Data transaksi berhasil dihapus.');
    }
}