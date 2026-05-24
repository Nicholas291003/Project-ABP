<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class TransactionReportController extends Controller
{
    public function index()
    {
        // Mengambil semua data transaksi dari yang paling baru
        $semuaTransaksi = Order::with(['user', 'schedule.route', 'schedule.transportation'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Menghitung total omset pendapatan dari tiket yang LUNAS
        $totalPendapatan = Order::where('status', 'lunas')->sum('total_price');

        return view('admin.laporan.index', compact('semuaTransaksi', 'totalPendapatan'));
    }
}