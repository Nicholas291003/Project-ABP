<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $methods = PaymentMethod::latest()->paginate(10);
        return view('admin.payment_methods.index', compact('methods'));
    }

    public function create()
    {
        return view('admin.payment_methods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|unique:payment_methods,kode',
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:bank,virtual_account,ewallet,qris',
            'nomor_tujuan' => 'required|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
            'instruksi_bayar' => 'nullable|string',
            'qr_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // Batasi berkas maks 2MB
        ]);

        $inputData = $request->all();

        // Proses penyimpanan berkas fisik jika kategori yang dipilih adalah QRIS
        if ($request->kategori === 'qris' && $request->hasFile('qr_file')) {
            $file = $request->file('qr_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Simpan ke direktori public/uploads/qris agar bisa diakses url-nya oleh Flutter
            $file->move(public_path('uploads/qris'), $filename);
            $inputData['qr_file'] = 'uploads/qris/' . $filename;
        }

        PaymentMethod::create($inputData);

        return redirect()->route('admin.payment-methods.index')->with('success', 'Metode pembayaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $method = PaymentMethod::findOrFail($id);
        return view('admin.payment_methods.edit', compact('method'));
    }

    public function update(Request $request, $id)
    {
        $method = PaymentMethod::findOrFail($id);

        $request->validate([
            'kode' => 'required|string|unique:payment_methods,kode,' . $method->id,
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:bank,virtual_account,ewallet,qris',
            'nomor_tujuan' => 'required|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
            'instruksi_bayar' => 'nullable|string',
            'qr_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $inputData = $request->all();

        if ($request->kategori === 'qris' && $request->hasFile('qr_file')) {
            // Hapus berkas lama jika ada sebelum menimpa dengan berkas baru
            if ($method->qr_file && file_exists(public_path($method->qr_file))) {
                unlink(public_path($method->qr_file));
            }

            $file = $request->file('qr_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/qris'), $filename);
            $inputData['qr_file'] = 'uploads/qris/' . $filename;
        }

        $method->update($inputData);

        return redirect()->route('admin.payment-methods.index')->with('success', 'Metode pembayaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $method = PaymentMethod::findOrFail($id);
        $method->delete();

        return redirect()->route('admin.payment-methods.index')->with('success', 'Metode pembayaran berhasil dihapus.');
    }
}