<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index(Request $request)
    {
        // 1. Hitung Data untuk Statistik Boks (Mini Stats)
        $total_rute = Route::count();
        
        // Menghitung jumlah kota unik (kombinasi asal & tujuan)
        $total_kota = Route::select('kota_asal')->union(Route::select('kota_tujuan'))->distinct()->get()->count();
        
        // Mengambil rute yang memiliki jadwal terbanyak (rute teraktif)
        $rute_terpopuler = Route::withCount('schedules')->orderBy('schedules_count', 'desc')->first();
        $rute_teraktif = $rute_terpopuler ? $rute_terpopuler->kode_rute : '-';

        // 2. Data Dropdown Filter Kota Asal dan Tujuan
        $list_kota_asal = Route::distinct()->orderBy('kota_asal', 'asc')->pluck('kota_asal');
        $list_kota_tujuan = Route::distinct()->orderBy('kota_tujuan', 'asc')->pluck('kota_tujuan');
        
        // 3. Logika Pencarian & Penyaringan Tabel
        $query = Route::query();

        // Filter Berdasarkan Kota Asal
        if ($request->filled('filter_asal')) {
            $query->where('kota_asal', $request->filter_asal);
        }

        // Filter Berdasarkan Kota Tujuan
        if ($request->filled('filter_tujuan')) {
            $query->where('kota_tujuan', $request->filter_tujuan);
        }

        // Filter Berdasarkan Jenis Transportasi ('kereta', 'bus', 'pesawat')
        if ($request->filled('filter_transportasi')) {
            $query->where('jenis', $request->filter_transportasi);
        }

        // Filter Pencarian Teks Bebas
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_rute', 'LIKE', "%{$search}%")
                ->orWhere('kota_asal', 'LIKE', "%{$search}%")
                ->orWhere('kota_tujuan', 'LIKE', "%{$search}%");
            });
        }

        $routes = $query->latest()->paginate(10)->withQueryString();

        return view('admin.routes.index', compact(
            'routes', 
            'total_rute', 
            'total_kota', 
            'rute_teraktif', 
            'list_kota_asal', 
            'list_kota_tujuan'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_rute' => 'required|string|unique:routes,kode_rute',
            'tarif_dasar' => 'required|integer|min:0',
            'kota_asal' => 'required|string|max:255',
            'simpul_asal' => 'required|string|max:255',
            'kota_tujuan' => 'required|string|max:255',
            'simpul_tujuan' => 'required|string|max:255',
            'jarak' => 'required|integer|min:0',
            'estimasi_jam' => 'required|integer|min:0',
            'estimasi_menit' => 'required|integer|min:0|max:59',
        ]);

        Route::create($request->all());

        return redirect()->route('admin.routes.index')->with('success', 'Rute baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $route = Route::findOrFail($id);

        $request->validate([
            'tarif_dasar' => 'required|integer|min:0',
            'kota_asal' => 'required|string|max:255',
            'simpul_asal' => 'required|string|max:255',
            'kota_tujuan' => 'required|string|max:255',
            'simpul_tujuan' => 'required|string|max:255',
            'jarak' => 'required|integer|min:0',
            'estimasi_jam' => 'required|integer|min:0',
            'estimasi_menit' => 'required|integer|min:0|max:59',
        ]);

        $route->update($request->all());

        return redirect()->route('admin.routes.index')->with('success', 'Data rute berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $route = Route::findOrFail($id);
        $route->delete();

        return redirect()->route('admin.routes.index')->with('success', 'Rute berhasil dihapus dari sistem.');
    }
}