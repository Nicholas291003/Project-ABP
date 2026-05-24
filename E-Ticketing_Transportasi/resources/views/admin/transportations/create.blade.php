@extends('layouts.admin')

@section('title', 'Tambah Transportasi - Travelgo')

@section('content')
<div class="p-8 space-y-8 flex-1 max-w-5xl">
    
    {{-- Header Aksi --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tight">Tambah Transportasi</h1>
            <p class="text-sm text-slate-400 mt-1">Masukkan detail spesifikasi armada baru yang akan beroperasi.</p>
        </div>
        <a href="{{ route('admin.transportations.index') }}" class="flex items-center space-x-2 px-4 py-2 rounded-xl border border-slate-700 bg-slate-800/40 text-slate-300 text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali</span>
        </a>
    </div>

    {{-- Form Isian Gaya Premium Kaca --}}
    <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 rounded-2xl p-6 md:p-8 shadow-xl shadow-black/10">
        <form action="{{ route('admin.transportations.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <h3 class="text-lg font-black text-slate-200 border-b pb-3 border-slate-800/60 flex items-center">
                <i data-lucide="info" class="w-5 h-5 text-teal-400 mr-2"></i> Informasi Kendaraan
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Jenis Armada <span class="text-rose-500">*</span></label>
                    <select name="jenis" id="select_jenis" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                        <option value="" disabled selected>Pilih Jenis Kendaraan</option>
                        <option value="kereta" {{ old('jenis') == 'kereta' ? 'selected' : '' }}>Kereta Api</option>
                        <option value="bus" {{ old('jenis') == 'bus' ? 'selected' : '' }}>Bus / Travel</option>
                        <option value="pesawat" {{ old('jenis') == 'pesawat' ? 'selected' : '' }}>Pesawat</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Kode Transportasi <span class="text-rose-500">*</span></label>
                    <div class="flex rounded-xl overflow-hidden shadow-sm">
                        <select name="kode_prefix" id="kode_prefix" required class="bg-slate-800 border border-slate-800 border-r-0 text-slate-200 text-sm font-bold px-4 py-2.5 focus:outline-none">
                            <option value="TRN" {{ old('kode_prefix') == 'TRN' ? 'selected' : '' }}>TRN</option>
                            <option value="BUS" {{ old('kode_prefix') == 'BUS' ? 'selected' : '' }}>BUS</option>
                            <option value="FLT" {{ old('kode_prefix') == 'FLT' ? 'selected' : '' }}>FLT</option>
                        </select>
                        <input type="text" name="kode_suffix" required placeholder="Contoh: 002" value="{{ old('kode_suffix') }}" class="w-full bg-slate-950 border border-slate-800 rounded-r-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 uppercase transition-all">
                    </div>
                    @error('kode')
                        <p class="text-xs text-rose-400 font-semibold mt-2 bg-rose-500/10 p-2 rounded border border-rose-500/20">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Nama Transportasi <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Sinar Jaya Raya" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Kelas Layanan <span class="text-rose-500">*</span></label>
                    <select name="kelas" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                        <option value="" disabled selected>Pilih Kelas Layanan</option>
                        <option value="Economy" {{ old('kelas') == 'Economy' ? 'selected' : '' }}>Economy</option>
                        <option value="Eksekutif" {{ old('kelas') == 'Eksekutif' ? 'selected' : '' }}>Eksekutif</option>
                        <option value="Luxury" {{ old('kelas') == 'Luxury' ? 'selected' : '' }}>Luxury</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Jumlah Total Kursi <span class="text-rose-500">*</span></label>
                    <input type="number" name="jumlah_kursi" value="{{ old('jumlah_kursi') }}" required min="1" placeholder="0" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Status Operasional <span class="text-rose-500">*</span></label>
                    <select name="status" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">
                        <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Dalam Perbaikan (Maintenance)</option>
                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Fasilitas Kendaraan</label>
                <textarea name="fasilitas" rows="3" placeholder="Contoh: AC, Reclining Seat, Snack, Toilet..." class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-teal-400 transition-all">{{ old('fasilitas') }}</textarea>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-800/60">
                <button type="reset" class="px-5 py-2.5 rounded-xl border border-slate-700 bg-slate-800/20 text-slate-400 text-sm font-semibold hover:bg-slate-800/40 hover:text-slate-200 transition-all">
                    Reset Form
                </button>
                <button type="submit" class="flex items-center space-x-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-teal-400 to-cyan-500 text-slate-950 text-sm font-bold hover:brightness-110 transition-all shadow-lg shadow-teal-500/20">
                    <i data-lucide="save" class="w-4.5 h-4.5 stroke-[2.5px]"></i> 
                    <span>Simpan Data</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('select_jenis').addEventListener('change', function() {
            const jenisKendaraan = this.value;
            const selectPrefix = document.getElementById('kode_prefix');

            if (jenisKendaraan === 'kereta') {
                selectPrefix.value = 'TRN';
            } else if (jenisKendaraan === 'bus') {
                selectPrefix.value = 'BUS';
            } else if (jenisKendaraan === 'pesawat') {
                selectPrefix.value = 'FLT';
            }
        });
    });
</script>
@endsection