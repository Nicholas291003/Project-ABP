@extends('layouts.admin')

@section('title', 'Edit Metode Pembayaran - Travelgo')

@section('content')
<div class="p-8 space-y-8 flex-1 max-w-5xl">
    
    {{-- Header Aksi --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tight">Edit Metode Pembayaran</h1>
            <p class="text-sm text-slate-400 mt-1">Lakukan pembaruan data atau perbarui berkas dokumen pembayaran.</p>
        </div>
        <a href="{{ route('admin.payment-methods.index') }}" class="flex items-center space-x-2 px-4 py-2 rounded-xl border border-slate-700 bg-slate-800/40 text-slate-300 text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali</span>
        </a>
    </div>

    {{-- Form Edit Gaya Premium Kaca --}}
    <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 rounded-2xl p-6 md:p-8 shadow-xl shadow-black/10">
        {{-- WAJIB: Atribut enctype untuk mendukung pemrosesan kiriman file baru --}}
        <form action="{{ route('admin.payment-methods.update', $method->id) }}" method="POST" enctype="multipart/multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Kode Channel <span class="text-rose-500">*</span></label>
                    <input type="text" name="kode" required value="{{ old('kode', $method->kode) }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 uppercase transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nama Metode <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama" required value="{{ old('nama', $method->nama) }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Kategori <span class="text-rose-500">*</span></label>
                    <select name="kategori" id="select_kategori" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                        <option value="bank" {{ old('kategori', $method->kategori) == 'bank' ? 'selected' : '' }}>Bank Transfer (Manual Check)</option>
                        <option value="virtual_account" {{ old('kategori', $method->kategori) == 'virtual_account' ? 'selected' : '' }}>Virtual Account</option>
                        <option value="ewallet" {{ old('kategori', $method->kategori) == 'ewallet' ? 'selected' : '' }}>Digital E-Wallet</option>
                        <option value="qris" {{ old('kategori', $method->kategori) == 'qris' ? 'selected' : '' }}>QRIS Barcode / PDF</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nomor Rekening / Merchant ID <span class="text-rose-500">*</span></label>
                    <input type="text" name="nomor_tujuan" required value="{{ old('nomor_tujuan', $method->nomor_tujuan) }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Status <span class="text-rose-500">*</span></label>
                    <select name="status" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                        <option value="aktif" {{ old('status', $method->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $method->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <div id="wrapper_qr_upload" class="hidden space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-teal-400 uppercase tracking-wider mb-2">Perbarui Gambar QRIS / PDF</label>
                        <input type="file" name="qr_file" id="input_qr_file" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2 text-sm text-slate-300 focus:outline-none focus:border-teal-400 file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-teal-500/10 file:text-teal-400 hover:file:bg-teal-500/20">
                        <p class="text-[10px] text-slate-500 mt-1">Biarkan kosong jika Anda tidak ingin mengganti file QRIS lama.</p>
                    </div>

                    @if($method->qr_file)
                        <div class="p-3 bg-slate-900 border border-slate-800 rounded-xl flex items-center space-x-3 w-fit">
                            @if(pathinfo($method->qr_file, PATHINFO_EXTENSION) == 'pdf')
                                <i data-lucide="file-text" class="w-8 h-8 text-rose-400"></i>
                                <div class="text-xs">
                                    <p class="font-bold text-slate-300">Dokumen QRIS Lama.pdf</p>
                                    <a href="{{ asset($method->qr_file) }}" target="_blank" class="text-teal-400 hover:underline font-semibold mt-0.5 block">Lihat PDF</a>
                                </div>
                            @else
                                <img src="{{ asset($method->qr_file) }}" alt="QRIS Preview" class="w-12 h-12 rounded-lg object-cover border border-slate-700">
                                <div class="text-xs">
                                    <p class="font-bold text-slate-300">Gambar_QRIS_Aktif.png</p>
                                    <a href="{{ asset($method->qr_file) }}" target="_blank" class="text-teal-400 hover:underline font-semibold mt-0.5 block">Perbesar Gambar</a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Instruksi Pembayaran</label>
                <textarea name="instruksi_bayar" rows="4" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">{{ old('instruksi_bayar', $method->instruksi_bayar) }}</textarea>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-800/60">
                <a href="{{ route('admin.payment-methods.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-700 bg-slate-800/20 text-slate-400 text-sm font-semibold hover:bg-slate-800/40 hover:text-slate-200 transition-all">
                    Batal
                </a>
                <button type="submit" class="flex items-center space-x-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-teal-400 to-cyan-500 text-slate-950 text-sm font-bold hover:brightness-110 transition-all shadow-lg shadow-teal-500/20">
                    <i data-lucide="save" class="w-4.5 h-4.5 stroke-[2.5px]"></i> 
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectKategori = document.getElementById('select_kategori');
        const wrapperQrUpload = document.getElementById('wrapper_qr_upload');

        function toggleQrInput() {
            if (selectKategori.value === 'qris') {
                wrapperQrUpload.classList.remove('hidden');
            } else {
                wrapperQrUpload.classList.add('hidden');
            }
        }

        toggleQrInput();
        selectKategori.addEventListener('change', toggleQrInput);
    });
</script>
@endsection