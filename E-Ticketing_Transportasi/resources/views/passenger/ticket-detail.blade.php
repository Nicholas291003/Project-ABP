@extends('layouts.passenger')

@section('title', 'Detail E-Ticket - ' . $ticket->order_code)

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    
    {{-- Tombol Kembali --}}
    <div class="flex items-center">
        <a href="{{ route('passenger.tickets') }}" class="flex items-center space-x-2 text-xs font-bold text-slate-500 hover:text-teal-600 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Kembali ke Daftar Tiket</span>
        </a>
    </div>

    {{-- MAIN BOARDING PASS CARD --}}
    <div class="bg-white/90 border border-white/60 backdrop-blur-md rounded-3xl shadow-xl shadow-zinc-200/50 overflow-hidden">
        
        {{-- Bagian Atas Tiket --}}
        <div class="bg-gradient-to-r from-teal-500 to-cyan-500 p-5 text-slate-950 flex items-center justify-between">
            <div class="flex items-center space-x-2.5">
                <div class="w-8 h-8 rounded-lg bg-slate-950/10 flex items-center justify-center">
                    <i data-lucide="tickets" class="w-5 h-5 text-slate-950"></i>
                </div>
                <div>
                    <h3 class="font-black text-sm tracking-tight">E-Ticket Boarding Pass</h3>
                    <p class="text-[10px] font-bold text-teal-900/80 uppercase tracking-wider">Travelgo Resmi</p>
                </div>
            </div>
            <span class="text-xs font-black bg-slate-950 text-white px-3 py-1 rounded-lg tracking-wide">{{ $ticket->order_code }}</span>
        </div>

        {{-- Detil Konten Boarding Pass --}}
        <div class="p-6 space-y-5">
            
            {{-- Manifest Grid Atas --}}
            <div class="grid grid-cols-2 gap-4 border-b border-slate-100 pb-4">
                <div>
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider block">Nama Penumpang</span>
                    <span class="text-sm font-black text-slate-800">{{ $ticket->user->name }}</span>
                </div>
                <div>
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider block">Kuantitas Penumpang</span>
                    <span class="text-sm font-black text-slate-800">{{ $ticket->total_passengers }} Pax (Kursi)</span>
                </div>
            </div>

            {{-- Spesifikasi Armada --}}
            <div class="grid grid-cols-2 gap-4 border-b border-slate-100 pb-4">
                <div>
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider block">Armada Kendaraan</span>
                    <span class="text-sm font-black text-slate-800 flex items-center mt-0.5">
                        <span class="mr-1.5">
                            @if($ticket->schedule->transportation->jenis == 'kereta')
                                <i data-lucide="train" class="w-4 h-4"></i>
                            @elseif($ticket->schedule->transportation->jenis == 'bus')
                                <i data-lucide="bus" class="w-4 h-4"></i>
                            @else
                                <i data-lucide="plane-takeoff" class="w-4 h-4"></i>
                            @endif
                        </span>
                        {{ $ticket->schedule->transportation->nama }}
                    </span>
                </div>
                <div>
                    <span class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider block">Jenis & Kelas</span>
                    <span class="text-sm font-black text-teal-600 mt-0.5 capitalize">{{ $ticket->schedule->transportation->jenis }} ({{ $ticket->schedule->transportation->kelas }})</span>
                </div>
            </div>

            {{-- Alur Rute Keberangkatan --}}
            <div class="bg-slate-50 border border-slate-100 p-4 rounded-2xl flex items-center justify-between">
                <div>
                    <span class="text-[10px] text-slate-400 font-bold uppercase">Asal</span>
                    <p class="text-base font-black text-slate-800 mt-0.5">{{ $ticket->schedule->route->kota_asal }}</p>
                    <p class="text-[10px] text-slate-400 font-medium max-w-[130px] mt-0.5 leading-tight">{{ $ticket->schedule->route->simpul_asal }}</p>
                </div>
                <div class="text-center px-2">
                    <p class="text-[9px] text-teal-600 font-extrabold uppercase tracking-wider mb-1">Berangkat</p>
                    <div class="w-14 h-6 bg-teal-500/10 border border-teal-500/20 text-teal-600 text-xs font-black rounded-lg flex items-center justify-center">
                        {{ substr($ticket->schedule->departure_time, 0, 5) }}
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-[10px] text-slate-400 font-bold uppercase">Tujuan</span>
                    <p class="text-base font-black text-slate-800 mt-0.5">{{ $ticket->schedule->route->kota_tujuan }}</p>
                    <p class="text-[10px] text-slate-400 font-medium max-w-[130px] mt-0.5 leading-tight">{{ $ticket->schedule->route->simpul_tujuan }}</p>
                </div>
            </div>

            {{-- Bagian QR Code & Validasi Status --}}
            <div class="flex flex-col items-center justify-center pt-2 border-b border-slate-100 pb-5">
                @if($ticket->status === 'lunas')
                    <div class="w-36 h-36 bg-slate-50 border border-slate-200 rounded-3xl p-3 shadow-inner mb-3 flex items-center justify-center">
                        <i data-lucide="qr-code" class="w-full h-full text-slate-800"></i>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-600 border border-emerald-500/20 shadow-sm shadow-emerald-500/5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span> Status: E-Ticket Aktif
                    </span>
                @else
                    <div class="w-24 h-24 bg-rose-50 border border-rose-100 rounded-2xl flex items-center justify-center text-rose-400 mb-3">
                        <i data-lucide="ban" class="w-12 h-12"></i>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-500/10 text-rose-600 border border-rose-500/20">
                        Status: Tiket Dibatalkan / Refunded
                    </span>
                @endif
            </div>

            {{-- Fitur Pembatalan Form Post Dinamik --}}
            @if($ticket->status === 'lunas')
                <div class="pt-1">
                    <form action="{{ route('passenger.ticket.cancel', $ticket->order_code) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan tiket ini? Dana Anda akan dikembalikan lewat Refund otomatis dan kursi dilepas.')">
                        @csrf
                        <button type="submit" class="w-full bg-rose-500/10 hover:bg-rose-500 hover:text-white text-rose-600 font-bold py-3 rounded-2xl text-xs transition-all tracking-wide flex items-center justify-center border border-rose-500/20 shadow-sm cursor-pointer">
                            <i data-lucide="rotate-ccw" class="w-4 h-4 mr-1.5 stroke-[2.5px]"></i> 
                            <span>Batalkan Tiket & Ajukan Refund</span>
                        </button>
                    </form>
                </div>
            @else
                <div class="pt-1 text-center text-xs text-slate-400 font-medium italic bg-slate-50 border border-slate-100 p-3 rounded-xl">
                    Tiket ini sudah tidak dapat di-refund karena telah hangus atau dibatalkan sebelumnya.
                </div>
            @endif

        </div>
    </div>
</div>
@endsection