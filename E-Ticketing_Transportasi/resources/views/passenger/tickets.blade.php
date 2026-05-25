@extends('layouts.passenger')

@section('title', 'Tiket Perjalanan Aktif')

@section('content')
<div class="space-y-6 max-w-4xl">
    
    {{-- Header Halaman --}}
    <div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Tiket Perjalanan Aktif</h1>
        <p class="text-sm text-slate-500 mt-1">Daftar e-ticket resmi Anda yang siap digunakan untuk boarding di terminal/stasiun.</p>
    </div>

    {{-- Looping Tiket Pengguna --}}
    @forelse($tickets as $ticket)
        <div class="bg-white/80 border border-white/50 backdrop-blur-md rounded-3xl p-6 shadow-xl shadow-zinc-200/40 relative overflow-hidden flex flex-col md:flex-row justify-between items-center gap-6 group hover:border-teal-500/30 transition-all duration-300">
            
            {{-- Dekorasi Latar Belakang Samar --}}
            <div class="absolute -right-10 -bottom-10 opacity-[0.03] pointer-events-none text-slate-900">
                @if($ticket->schedule->transportation->jenis == 'kereta')
                    <i data-lucide="train" class="w-44 h-44"></i>
                @elseif($ticket->schedule->transportation->jenis == 'bus')
                    <i data-lucide="bus" class="w-44 h-44"></i>
                @else
                    <i data-lucide="plane" class="w-44 h-44"></i>
                @endif
            </div>

            {{-- Informasi Detil Kiri --}}
            <div class="flex-1 space-y-4 w-full">
                <div class="flex items-center justify-between md:justify-start space-x-3">
                    <span class="px-3 py-1 rounded-full text-[10px] font-black bg-teal-500/10 text-teal-600 border border-teal-500/20 flex items-center space-x-1 capitalize">
                        <span>
                            @if($ticket->schedule->transportation->jenis == 'kereta')
                                <i data-lucide="train" class="w-4 h-4"></i>
                            @elseif($ticket->schedule->transportation->jenis == 'bus')
                                <i data-lucide="bus" class="w-4 h-4"></i>
                            @else
                                <i data-lucide="plane-takeoff" class="w-4 h-4"></i>
                            @endif
                        </span>
                        <span>{{ $ticket->schedule->transportation->jenis }}</span>
                    </span>
                    <span class="text-xs text-slate-400 font-bold">ID Tiket: {{ $ticket->order_code }}</span>
                </div>
                
                <div>
                    <h3 class="text-lg font-black text-slate-800 group-hover:text-teal-600 transition-colors">{{ $ticket->schedule->transportation->nama }}</h3>
                    <p class="text-xs text-slate-400 font-medium mt-0.5">{{ $ticket->schedule->transportation->kelas }}</p>
                </div>

                {{-- Jalur Keberangkatan Rute --}}
                <div class="flex items-center space-x-4 pt-1">
                    <div>
                        <h4 class="text-base font-black text-slate-800">{{ substr($ticket->schedule->departure_time, 0, 5) }}</h4>
                        <p class="text-xs font-bold text-slate-600">{{ $ticket->schedule->route->kota_asal }}</p>
                        <p class="text-[10px] text-slate-400 leading-tight max-w-[140px] truncate mt-0.5">{{ $ticket->schedule->route->simpul_asal }}</p>
                    </div>
                    <div class="flex-1 px-2 relative flex items-center justify-center">
                        <div class="w-full h-[2px] bg-dashed bg-slate-200 relative flex items-center justify-center">
                            <div class="absolute w-1.5 h-1.5 rounded-full bg-teal-400"></div>
                            <div class="absolute text-[13px] text-slate-300 translate-y-[-1px]">➔</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <h4 class="text-base font-black text-slate-800">{{ substr($ticket->schedule->arrival_time, 0, 5) }}</h4>
                        <p class="text-xs font-bold text-slate-600">{{ $ticket->schedule->route->kota_tujuan }}</p>
                        <p class="text-[10px] text-slate-400 leading-tight max-w-[140px] truncate mt-0.5">{{ $ticket->schedule->route->simpul_tujuan }}</p>
                    </div>
                </div>
            </div>

            {{-- Pembatas Garis Putus --}}
            <div class="hidden md:block w-[1px] h-28 bg-slate-200/60 border-dashed border-l"></div>

            {{-- Sisi Kanan: Tanggal & QR Button --}}
            <div class="w-full md:w-44 flex flex-col items-center justify-center text-center space-y-3.5">
                <div class="text-center">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Tanggal Berangkat</p>
                    <p class="text-sm font-black text-slate-700 mt-0.5">{{ \Carbon\Carbon::parse($ticket->schedule->departure_date)->format('d M Y') }}</p>
                </div>

                <div class="w-14 h-14 bg-slate-50 border border-slate-200/80 rounded-xl flex items-center justify-center p-1.5 shadow-inner">
                    <i data-lucide="qr-code" class="w-full h-full text-slate-600"></i>
                </div>

                <a href="{{ route('passenger.ticket.show', $ticket->order_code) }}" class="w-full text-center bg-teal-500 hover:bg-teal-600 text-white font-bold py-2 rounded-xl text-xs transition-all shadow-md shadow-teal-500/10 cursor-pointer">
                    Detail Tiket
                </a>
            </div>

        </div>
    @empty
        {{-- Kondisi Kosong --}}
        <div class="bg-white/80 border border-white/50 backdrop-blur-md rounded-3xl p-12 text-center shadow-md flex flex-col items-center justify-center h-64">
            <div class="w-14 h-14 bg-teal-50 text-teal-500 rounded-full flex items-center justify-center mb-3">
                <i data-lucide="ticket" class="w-6 h-6"></i>
            </div>
            <p class="text-slate-500 font-bold text-sm">Anda tidak memiliki tiket aktif saat ini.</p>
        </div>
    @endforelse

    {{-- Link Pagination Proyek --}}
    <div class="pt-2">
        {{ $tickets->links() }}
    </div>
</div>
@endsection