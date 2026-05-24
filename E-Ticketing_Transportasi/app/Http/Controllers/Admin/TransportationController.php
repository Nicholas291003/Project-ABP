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
    public function index()
    {
        // Mengambil data terbaru dengan pagination (10 per halaman)
        $transportations = Transportation::latest()->paginate(10);
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
