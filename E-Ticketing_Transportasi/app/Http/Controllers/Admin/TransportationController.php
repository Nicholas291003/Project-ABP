<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transportation;
use Illuminate\Http\Request;

class TransportationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transportation::query();

        // 1. Filter Berdasarkan Jenis Kendaraan
        if ($request->filled('filter_jenis')) {
            $query->where('jenis', $request->filter_jenis);
        }

        // 2. PERBAIKAN: Gunakan LIKE agar kata "Ekonomi" bisa menyaring data "Eksekutif & Ekonomi Premium"
        if ($request->filled('filter_kelas')) {
            $query->where('kelas', 'LIKE', "%" . $request->filter_kelas . "%");
        }

        // 3. Filter Berdasarkan Teks Pencarian Nama/Kode
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                ->orWhere('kode', 'LIKE', "%{$search}%");
            });
        }

        // Ambil hasil akhir dengan paginasi terikat query string
        $transportations = $query->latest()->paginate(10)->withQueryString();

        return view('admin.transportations.index', compact('transportations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.transportations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $kodeLengkap = strtoupper($request->kode_prefix) . '-' . strtoupper($request->kode_suffix);
        
        $request->merge(['kode' => $kodeLengkap]);
        
        $request->validate([
            'kode' => 'required|string|unique:transportations,kode',
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:kereta,bus,pesawat',
            'kelas' => 'required|in:Ekonomi,Bisnis,Eksekutif',
            'jumlah_kursi' => 'required|integer|min:1',
            'status' => 'required|in:aktif,maintenance,nonaktif',
            'fasilitas' => 'nullable|string',
        ], [

            'kode.unique' => 'Perinagatan: Kode transportasi '.$kodeLengkap .'sudah digunakan. Silakan gunakan kode lain.',
        ]);

        \App\Models\Transportation::create([
            'kode' => $kodeLengkap,
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'kelas' => $request->kelas,
            'jumlah_kursi' => $request->jumlah_kursi,
            'status' => $request->status,
            'fasilitas' => $request->fasilitas,
        ]);

        return redirect()->route('admin.transportations.index')->with('success', 'Transportasi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transportation $transportation)
    {
        return view('admin.transportations.show', compact('transportation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transportation $transportation)
    {
        return view('admin.transportations.edit', compact('transportation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transportation $transportation)
    {
        $request->validate([
            'kode' => 'required|string|unique:transportations,kode,' . $transportation->id,
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:kereta,bus,pesawat',
            'kelas' => 'required|in:Ekonomi,Bisnis,Eksekutif',
            'jumlah_kursi' => 'required|integer|min:1',
            'status' => 'required|in:aktif,maintenance,nonaktif',
            'fasilitas' => 'nullable|string',
        ]);

        $transportation->update($request->all());

        return redirect()->route('admin.transportations.index')->with('success', 'Transportasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transportation $transportation)
    {
        $transportation->delete();
        return redirect()->route('admin.transportations.index')
            ->with('success', 'Transportasi berhasil dihapus.');
    }
}
