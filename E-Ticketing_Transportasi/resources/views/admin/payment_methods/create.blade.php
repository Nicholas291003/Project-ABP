@extends('layouts.admin')

@section('title', 'Tambah Metode Pembayaran - Travelgo')

@section('content')
<div class="p-8 space-y-8 flex-1 max-w-5xl">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tight">Tambah Metode Pembayaran</h1>
            <p class="text-sm text-slate-400 mt-1">Masukkan data instrumen keuangan pembayaran baru.</p>
        </div>
        <a href="{{ route('admin.payment-methods.index') }}" class="flex items-center space-x-2 px-4 py-2 rounded-xl border border-slate-700 bg-slate-800/40 text-slate-300 text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 rounded-2xl p-6 md:p-8 shadow-xl">
        <form action="{{ route('admin.payment-methods.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Kode Channel <span class="text-rose-500">*</span></label>
                    <input type="text" name="kode" required placeholder="Contoh: QRIS-TRAVELGO" value="{{ old('kode') }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 uppercase transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nama Metode <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama" required placeholder="Contoh: QRIS All Payment" value="{{ old('nama') }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Kategori <span class="text-rose-500">*</span></label>
                    <select name="kategori" id="select_kategori" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                        <option value="bank">Bank Transfer (Manual Check)</option>
                        <option value="virtual_account">Virtual Account</option>
                        <option value="ewallet">Digital E-Wallet</option>
                        <option value="qris">QRIS Barcode / PDF</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nomor Rekening / Merchant ID <span class="text-rose-500">*</span></label>
                    <input type="text" name="nomor_tujuan" required placeholder="Contoh: 8832918239 atau NMI-92831" value="{{ old('nomor_tujuan', '-') }}" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Status <span class="text-rose-500">*</span></label>
                    <select name="status" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>

                {{-- INPUT DOKUMEN: Tersembunyi secara default, hanya muncul jika kategori QRIS dipilih --}}
                <div id="wrapper_qr_upload" class="hidden">
                    <label class="block text-xs font-bold text-teal-400 uppercase tracking-wider mb-2">Unggah Gambar QRIS / Dokumen PDF <span class="text-rose-500">*</span></label>
                    <input type="file" name="qr_file" id="input_qr_file" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2 text-sm text-slate-300 focus:outline-none focus:border-teal-400 file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-teal-500/10 file:text-teal-400 hover:file:bg-teal-500/20">
                    <p class="text-[11px] text-slate-500 mt-1.5">Mendukung format file: .jpg, .jpeg, .png, atau .pdf (Maksimal berkas 2MB).</p>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Instruksi Pembayaran</label>
                <textarea name="instruksi_bayar" rows="4" placeholder="Langkah-langkah transaksi..." class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">{{ old('instruksi_bayar') }}</textarea>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-800/60">
                <button type="submit" class="flex items-center space-x-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-teal-400 to-cyan-500 text-slate-950 text-sm font-bold hover:brightness-110 transition-all shadow-lg shadow-teal-500/20">
                    <i data-lucide="save" class="w-4.5 h-4.5 stroke-[2.5px]"></i> 
                    <span>Simpan Channel</span>
                </button>
            </div>
        </form>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectKategori = document.getElementById('select_kategori');
            const wrapperQrUpload = document.getElementById('wrapper_qr_upload');
            const inputQrFile = document.getElementById('input_qr_file');

            function toggleQrInput() {
                if (selectKategori.value === 'qris') {
                    wrapperQrUpload.classList.remove('hidden');
                    inputQrFile.setAttribute('required', 'required');
                } else {
                    wrapperQrUpload.classList.add('hidden');
                    inputQrFile.removeAttribute('required');
                    inputQrFile.value = ''; // Reset file input jika kategori diganti
                }
            }

            // Jalankan fungsi saat halaman pertama kali dimuat dan setiap kali opsi select diubah
            toggleQrInput();
            selectKategori.addEventListener('change', toggleQrInput);
        });
    </script>
    
    </div>
</div>
@endsection