@extends('layouts.admin')

@section('title', 'Data Transportasi - Travelgo')

@section('content')
<div class="p-8 space-y-8 flex-1">
    
    {{-- Notifikasi Sukses Gunting Kaca --}}
    @if(session('success'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 rounded-xl flex items-center shadow-lg shadow-black/10">
            <i data-lucide="check-circle" class="mr-2 w-5 h-5"></i> 
            <span class="text-sm font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Header Halaman --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tight">Data Transportasi</h1>
            <p class="text-sm text-slate-400 mt-1">Kelola data seluruh armada kendaraan yang tersedia di sistem.</p>
        </div>
        <a href="{{ route('admin.transportations.create') }}" class="flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-teal-400 to-cyan-500 text-slate-950 text-sm font-bold hover:brightness-110 transition-all shadow-lg shadow-teal-500/20">
            <i data-lucide="plus" class="w-4.5 h-4.5 stroke-[3px]"></i>
            <span>Tambah Armada</span>
        </a>
    </div>

    {{-- Filter & Pencarian Kontrol Kaca --}}
    <form action="{{ route('admin.transportations.index') }}" method="GET" class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 p-4 rounded-t-2xl flex flex-col sm:flex-row justify-between items-center gap-4 w-full">
        <div class="flex space-x-2 w-full sm:w-auto">
            
            {{-- Dropdown Jenis Transportasi --}}
            <select name="filter_jenis" onchange="this.form.submit()" class="bg-slate-900 border border-slate-800 text-slate-300 text-sm rounded-xl focus:outline-none focus:border-teal-400 px-3 py-2 transition-all cursor-pointer">
                <option value="">Semua Jenis</option>
                <option value="kereta" {{ request('filter_jenis') == 'kereta' ? 'selected' : '' }}>Kereta Api</option>
                <option value="bus" {{ request('filter_jenis') == 'bus' ? 'selected' : '' }}>Bus / Travel</option>
                <option value="pesawat" {{ request('filter_jenis') == 'pesawat' ? 'selected' : '' }}>Pesawat</option>
            </select>

            {{-- Dropdown Pilihan Kelas (Disamakan dengan Teks di Database Anda) --}}
            <select name="filter_kelas" onchange="this.form.submit()" class="bg-slate-900 border border-slate-800 text-slate-300 text-sm rounded-xl focus:outline-none focus:border-teal-400 px-3 py-2 transition-all cursor-pointer">
                <option value="">Semua Kelas</option>
                <option value="Ekonomi" {{ request('filter_kelas') == 'Ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                <option value="Bisnis" {{ request('filter_kelas') == 'Bisnis' ? 'selected' : '' }}>Bisnis</option>
                <option value="Eksekutif" {{ request('filter_kelas') == 'Eksekutif' ? 'selected' : '' }}>Eksekutif</option>
                <option value="Luxury" {{ request('filter_kelas') == 'Luxury' ? 'selected' : '' }}>Luxury</option>
            </select>

        </div>

        {{-- Kolom Input Teks Pencarian --}}
        <div class="relative w-full sm:w-72">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-500">
                <i data-lucide="search" class="w-4 h-4"></i>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" class="w-full bg-slate-900 border border-slate-800 rounded-xl text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-teal-400 pl-10 p-2.5 transition-all" placeholder="Cari nama atau kode...">
        </div>
    </form>

    {{-- Tabel Data Utama --}}
    <div class="bg-slate-950/40 backdrop-blur-md border border-slate-800/80 rounded-b-2xl overflow-hidden shadow-xl shadow-black/10">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-800 text-[11px] text-slate-500 font-extrabold uppercase tracking-widest bg-slate-950/20">
                        <th class="py-4 px-6">Kode</th>
                        <th class="py-4 px-6">Nama Transportasi</th>
                        <th class="py-4 px-6">Jenis & Kelas</th>
                        <th class="py-4 px-6 text-center">Kursi</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-800/40">
                    @forelse($transportations as $item)
                    <tr class="text-slate-300 hover:bg-slate-900/30 transition group">
                        <td class="py-4 px-6 font-bold text-slate-200 group-hover:text-teal-400 transition-colors">{{ $item->kode }}</td>
                        <td class="py-4 px-6 font-semibold text-slate-200">{{ $item->nama }}</td>
                        <td class="py-4 px-6">
                            <div class="flex items-center text-slate-300 font-medium">
                                @if($item->jenis == 'kereta')
                                    <i data-lucide="train" class="text-teal-400 mr-2 w-4 h-4"></i> Kereta Api
                                @elseif($item->jenis == 'bus')
                                    <i data-lucide="bus" class="text-teal-400 mr-2 w-4 h-4"></i> Bus
                                @else
                                    <i data-lucide="plane-takeoff" class="text-teal-400 mr-2 w-4 h-4"></i> Pesawat
                                @endif
                            </div>
                            <span class="text-xs text-slate-500 mt-1 block font-medium">{{ $item->kelas }}</span>
                        </td>
                        <td class="py-4 px-6 text-center font-bold text-slate-300">{{ $item->jumlah_kursi }}</td>
                        <td class="py-4 px-6">
                            @if($item->status == 'aktif')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Aktif</span>
                            @elseif($item->status == 'maintenance')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20">Maintenance</span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-500/10 text-rose-400 border border-rose-500/20">Nonaktif</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{ route('admin.transportations.edit', $item->id) }}" class="p-2 rounded-lg bg-slate-900 border border-slate-800 text-slate-400 hover:text-teal-400 hover:border-teal-400 transition-all inline-flex items-center" title="Edit">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>
                                
                                <form action="{{ route('admin.transportations.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus armada ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg bg-slate-900 border border-slate-800 text-slate-400 hover:text-rose-400 hover:border-rose-400 transition-all inline-flex items-center cursor-pointer" title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500 font-medium">Belum ada data armada transportasi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Navigasi Paginasi Gelap --}}
        <div class="px-6 py-4 border-t border-slate-800/60 bg-slate-950/20">
            {{ $transportations->links() }}
        </div>
    </div>
</div>
@endsection