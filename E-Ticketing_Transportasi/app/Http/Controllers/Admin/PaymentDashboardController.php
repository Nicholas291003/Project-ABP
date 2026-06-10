<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentDashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil Data Real-Time untuk Boks Mini Statistik (Meniru Komponen Pusat Referensi)
        $total_pendapatan = Order::whereIn('status', ['lunas', 'sukses'])->sum('total_price');
        $dana_pending = Order::where('status', 'pending')->sum('total_price');

        // 2. Ambil Daftar Invoice Terkini (Panel Kanan Atas)
        $invoices = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 3. Ambil Log Detail Transaksi Masuk Masal (Panel Kanan Bawah)
        $transactions = Order::with(['schedule.route', 'schedule.transportation'])
            ->orderBy('created_at', 'desc')
            ->paginate(6, ['*'], 'tx_page')
            ->withQueryString();

        // 4. Ambil Informasi Tagihan Pelanggan Terbaru (Panel Kiri Bawah)
        $billing_infos = Order::with('user')
            ->whereIn('status', ['lunas', 'sukses'])
            ->orderBy('updated_at', 'desc')
            ->take(3)
            ->get();

        return view('admin.payments.index', compact(
            'total_pendapatan',
            'dana_pending',
            'invoices',
            'transactions',
            'billing_infos'
        ));
    }

    public function showInvoice($id)
    {
        // Cari data transaksi pesanan berdasarkan ID beserta seluruh relasi tabelnya
        $order = Order::with(['user', 'schedule.route', 'schedule.transportation'])->findOrFail($id);

        return view('admin.payments.invoice', compact('order'));
    }
}