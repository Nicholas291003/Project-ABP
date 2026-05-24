@extends('layouts.passenger')

@section('title', 'Hasil Pencarian Tiket')

@section('content')
<div class="max-w-4xl mx-auto pb-24">
    
    <div class="mb-8 bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <span class="text-xs font-bold uppercase tracking-wider text-primary bg-blue-50 px-2.5 py-1 rounded-md">Hasil Pencarian {{ ucfirst($request->jenis) }}</span>
            <h1 class="text-xl font-bold text-gray-800 mt-2">
                {{ $request->kota_asal }} <i class="fa-solid fa-arrow-right mx-1.5 text-gray-400 text-sm"></i> {{ $request->kota_tujuan }}
            </h1>
            <p class="text-xs text-gray-500 mt-0.5"><i class="fa-regular fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($request->tanggal)->isoFormat('dddd, D MMMM YYYY') }}</p>
        </div>
        <a href="{{ route('passenger.dashboard') }}" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold px-4 py-2.5 rounded-xl transition">
            <i class="fa-solid fa-magnifying-glass mr-1"></i> Ubah Pencarian
        </a>
    </div>

    <div class="space-y-4">
        @forelse($schedules as $item)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row items-center justify-between gap-6 hover:border-primary/30 transition">
                
                <div class="w-full md:w-1/4">
                    <h3 class="font-extrabold text-gray-800 text-base leading-tight">{{ $item->transportation->name }}</h3>
                    <span class="inline-block text-[10px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded font-bold uppercase tracking-wide mt-1.5">{{ $item->transportation->class }}</span>
                </div>

                <div class="w-full md:w-2/5 flex items-center justify-between text-center relative px-2">
                    <div class="text-left">
                        <p class="text-base font-bold text-gray-800">{{ substr($item->departure_time, 0, 5) }}</p>
                        <p class="text-[11px] text-gray-400 font-medium mt-0.5">{{ $item->route->simpul_asal }}</p>
                    </div>
                    
                    <div class="flex-1 px-4 text-center">
                        <p class="text-[10px] text-gray-400 font-bold tracking-tight mb-1">{{ $item->route->estimasi_jam }}j {{ $item->route->estimasi_menit }}m</p>
                        <div class="h-0.5 w-full bg-gray-200 border-dashed border-t relative flex items-center justify-center">
                            <i class="fa-solid fa-chevron-right absolute right-0 text-gray-300 text-[10px]"></i>
                        </div>
                    </div>

                    <div class="text-right">
                        <p class="text-base font-bold text-gray-800">{{ substr($item->arrival_time, 0, 5) }}</p>
                        <p class="text-[11px] text-gray-400 font-medium mt-0.5">{{ $item->route->simpul_tujuan }}</p>
                    </div>
                </div>

                <div class="w-full md:w-1/3 flex md:flex-col items-center md:items-end justify-between md:justify-center gap-2 border-t md:border-t-0 pt-4 md:pt-0 border-gray-100">
                    <div class="text-left md:text-right">
                        @if($item->remaining_seats == 0)
                            <p class="text-[11px] text-red-500 font-bold mb-0.5"><i class="fa-solid fa-triangle-exclamation"></i> Kuota Kursi Habis</p>
                        @else
                            <p class="text-[11px] text-primary font-bold mb-0.5">Sisa {{ $item->remaining_seats }} Kursi Tersedia</p>
                        @endif
                        <p class="text-xl font-black text-secondary">Rp {{ number_format($item->price, 0, ',', '.') }}<span class="text-[10px] text-gray-400 font-normal">/pax</span></p>
                    </div>

                    @if($item->remaining_seats > 0)
                        <a href="{{ route('passenger.seats.show', $item->id) }}" class="bg-primary hover:bg-primaryDark text-white font-bold text-xs px-5 py-3 rounded-xl shadow-sm transition tracking-wider block text-center md:w-auto">
                            PILIH KURSI <i class="fa-solid fa-chevron-right ml-1 text-[10px]"></i>
                        </a>
                    @else
                        <button disabled class="bg-gray-200 text-gray-400 font-bold text-xs px-5 py-3 rounded-xl cursor-not-allowed tracking-wider">
                            HABIS
                        </button>
                    @endif
                </div>

            </div>
        @empty
            <div class="bg-white rounded-2xl p-16 text-center border border-gray-100 shadow-sm flex flex-col items-center justify-center">
                <div class="w-16 h-16 bg-orange-50 text-secondary rounded-full flex items-center justify-center text-2xl mb-4">
                    <i class="fa-solid fa-plane-slash"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Tidak Ada Jadwal Tersedia</h3>
                <p class="text-sm text-gray-400 mt-1 max-w-sm">Maaf, tidak ditemukan jadwal operasional {{ $request->jenis }} aktif pada rute dan tanggal pilihan Anda.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection