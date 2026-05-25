@extends('layouts.passenger')

@section('title', 'Hasil Pencarian Tiket')

@section('content')
<div class="max-w-4xl mx-auto pb-24 space-y-6">
    
    {{-- Header Ringkasan Pencarian (Gaya Glassmorphism Kotak Foto 6) --}}
    <div class="bg-white/80 border border-white/50 backdrop-blur-md p-6 rounded-3xl shadow-xl shadow-zinc-200/40 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="space-y-1.5">
            <span class="inline-flex items-center px-3 py-1 rounded-xl text-[10px] font-black bg-teal-500/10 text-teal-600 border border-teal-500/20 uppercase tracking-wider">
                Hasil Pencarian {{ ucfirst($request->jenis) }}
            </span>
            <h1 class="text-xl font-black text-slate-800 flex items-center tracking-tight">
                <span>{{ $request->kota_asal }}</span>
                <i data-lucide="arrow-right" class="mx-2 text-slate-400 w-4 h-4 stroke-[2.5px]"></i>
                <span>{{ $request->kota_tujuan }}</span>
            </h1>
            <p class="text-xs text-slate-400 font-medium flex items-center">
                <i data-lucide="calendar" class="mr-1.5 w-3.5 h-3.5 text-slate-400"></i>
                {{ \Carbon\Carbon::parse($request->tanggal)->isoFormat('dddd, D MMMM YYYY') }}
            </p>
        </div>
        <a href="{{ route('passenger.dashboard') }}" class="inline-flex items-center space-x-1.5 text-xs bg-slate-200/60 hover:bg-slate-200 text-slate-700 font-bold px-4 py-2.5 rounded-xl transition-all cursor-pointer shadow-sm">
            <i data-lucide="search" class="w-3.5 h-3.5"></i>
            <span>Ubah Pencarian</span>
        </a>
    </div>

    {{-- Daftar Hasil Jadwal Keberangkatan --}}
    <div class="space-y-4">
        @forelse($schedules as $item)
            <div class="bg-white/80 border border-white/50 backdrop-blur-md rounded-3xl p-6 flex flex-col md:flex-row items-center justify-between gap-6 hover:border-teal-500/40 transition-all duration-300 shadow-lg shadow-zinc-200/30 group relative overflow-hidden">
                
                {{-- Info Nama Armada Kendaraan --}}
                <div class="w-full md:w-1/4">
                    <h3 class="font-black text-slate-800 text-base leading-tight group-hover:text-teal-600 transition-colors">{{ $item->transportation->name ?? $item->transportation->nama }}</h3>
                    <span class="inline-block text-[10px] bg-slate-100 border border-slate-200 text-slate-500 px-2.5 py-0.5 rounded-md font-bold uppercase tracking-wide mt-1.5">
                        {{ $item->transportation->class ?? $item->transportation->kelas }}
                    </span>
                </div>

                {{-- Jalur Timeline Keberangkatan & Kedatangan --}}
                <div class="w-full md:w-2/5 flex items-center justify-between text-center relative px-2">
                    <div class="text-left">
                        <p class="text-base font-black text-slate-800">{{ substr($item->departure_time, 0, 5) }}</p>
                        <p class="text-[11px] text-slate-400 font-semibold mt-0.5 tracking-tight truncate max-w-[90px]" title="{{ $item->route->simpul_asal }}">{{ $item->route->simpul_asal }}</p>
                    </div>
                    
                    <div class="flex-1 px-4 text-center">
                        <p class="text-[10px] text-slate-400 font-black tracking-tight mb-1">{{ $item->route->estimasi_jam }}j {{ $item->route->estimasi_menit }}m</p>
                        <div class="w-full h-[2px] bg-dashed bg-slate-200 relative flex items-center justify-center">
                            <div class="absolute w-1.5 h-1.5 rounded-full bg-teal-400"></div>
                            <div class="absolute text-[13px] text-slate-300 right-0 translate-y-[-1px]">➔</div>
                        </div>
                    </div>

                    <div class="text-right">
                        <p class="text-base font-black text-slate-800">{{ substr($item->arrival_time, 0, 5) }}</p>
                        <p class="text-[11px] text-slate-400 font-semibold mt-0.5 tracking-tight truncate max-w-[90px]" title="{{ $item->route->simpul_tujuan }}">{{ $item->route->simpul_tujuan }}</p>
                    </div>
                </div>

                {{-- Sisi Kanan: Sisa Kursi, Harga & Tombol Pesan --}}
                <div class="w-full md:w-1/3 flex md:flex-col items-center md:items-end justify-between md:justify-center gap-2 border-t md:border-t-0 pt-4 md:pt-0 border-slate-100">
                    <div class="text-left md:text-right">
                        @if($item->remaining_seats == 0)
                            <p class="text-[11px] text-rose-500 font-bold mb-0.5 flex items-center md:justify-end">
                                <i data-lucide="alert-triangle" class="w-3.5 h-3.5 mr-1"></i> Kuota Kursi Habis
                            </p>
                        @else
                            <p class="text-[11px] text-teal-600 font-extrabold mb-0.5">Sisa {{ $item->remaining_seats }} Kursi Tersedia</p>
                        @endif
                        <p class="text-xl font-black text-orange-500">Rp {{ number_format($item->price, 0, ',', '.') }}<span class="text-[10px] text-slate-400 font-normal">/pax</span></p>
                    </div>

                    {{-- Tombol Kondisional Pilihan Kursi --}}
                    @if($item->remaining_seats > 0)
                        <a href="{{ route('passenger.seats.show', $item->id) }}" class="inline-flex items-center space-x-1 bg-teal-500 hover:bg-teal-600 text-white font-extrabold text-xs px-5 py-2.5 rounded-xl shadow-md shadow-teal-500/10 transition-all tracking-wider block text-center md:w-auto cursor-pointer">
                            <span>PILIH KURSI</span>
                            <i data-lucide="chevron-right" class="w-3.5 h-3.5 stroke-[2.5px]"></i>
                        </a>
                    @else
                        <button disabled class="bg-slate-200 border border-slate-300 text-slate-400 font-bold text-xs px-5 py-2.5 rounded-xl cursor-not-allowed tracking-wider">
                            HABIS
                        </button>
                    @endif
                </div>

            </div>
        @empty
            {{-- Kondisi Apabila Jadwal Kosong --}}
            <div class="bg-white/80 border border-white/50 backdrop-blur-md rounded-3xl p-16 text-center shadow-xl shadow-zinc-200/40 flex flex-col items-center justify-center h-80">
                <div class="w-16 h-16 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center mb-4 border border-orange-100 shadow-inner">
                    <i data-lucide="frown" class="w-8 h-8"></i>
                </div>
                <h3 class="text-lg font-black text-slate-800 tracking-tight">Tidak Ada Jadwal Tersedia</h3>
                <p class="text-sm text-slate-400 mt-1 max-w-sm font-medium leading-relaxed">Maaf, tidak ditemukan jadwal operasional {{ $request->jenis }} aktif pada rute dan tanggal pilihan Anda.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection