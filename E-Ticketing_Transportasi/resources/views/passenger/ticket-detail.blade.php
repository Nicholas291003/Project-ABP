@extends('layouts.passenger')

@section('title', 'Detail E-Ticket')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden mt-4">
    
    <div class="bg-primary p-5 text-white text-center font-bold tracking-wide flex items-center justify-center relative">
        <a href="{{ route('passenger.tickets') }}" class="absolute left-5 text-white/80 hover:text-white transition">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        E-TICKET BOARDING PASS
    </div>
    
    <div class="p-6 space-y-4">
        <div class="flex justify-between border-b pb-3">
            <span class="text-gray-400 text-sm">Kode Tiket</span>
            <span class="font-bold text-gray-900 tracking-wide">{{ $ticket->order_code }}</span>
        </div>
        <div class="flex justify-between border-b pb-3">
            <span class="text-gray-400 text-sm">Nama Penumpang</span>
            <span class="font-bold text-gray-800">{{ $ticket->user->name }}</span>
        </div>
        <div class="flex justify-between border-b pb-3">
            <span class="text-gray-400 text-sm">Armada Kendaraan</span>
            <span class="font-semibold text-gray-800">{{ $ticket->schedule->transportation->nama }}</span>
        </div>
        <div class="flex justify-between border-b pb-3">
            <span class="text-gray-400 text-sm">Jenis & Kelas</span>
            <span class="font-semibold text-gray-800 capitalize">{{ $ticket->schedule->transportation->jenis }} ({{ $ticket->schedule->transportation->kelas }})</span>
        </div>
        <div class="flex justify-between border-b pb-3">
            <span class="text-gray-400 text-sm">Rute Jalur</span>
            <span class="font-medium text-gray-800">{{ $ticket->schedule->route->kota_asal }} ➔ {{ $ticket->schedule->route->kota_tujuan }}</span>
        </div>
        <div class="flex justify-between border-b pb-3">
            <span class="text-gray-400 text-sm">Waktu Keberangkatan</span>
            <span class="font-bold text-primary">{{ substr($ticket->schedule->departure_time, 0, 5) }} WIB</span>
        </div>
        <div class="flex justify-between border-b pb-3">
            <span class="text-gray-400 text-sm">Kuantitas Kursi</span>
            <span class="font-bold text-gray-800">{{ $ticket->total_passengers }} Pax</span>
        </div>

        <div class="flex flex-col items-center justify-center pt-4 border-b pb-6">
            @if($ticket->status === 'lunas')
                <i class="fa-solid fa-qrcode text-9xl text-gray-800 mb-2"></i>
                <p class="text-xs text-green-600 font-bold bg-green-50 px-3 py-1 rounded-full border border-green-100">
                    <i class="fa-solid fa-circle-check"></i> Status: E-Ticket Aktif
                </p>
            @else
                <i class="fa-solid fa-ban text-9xl text-gray-300 mb-2"></i>
                <p class="text-xs text-red-600 font-bold bg-red-50 px-3 py-1 rounded-full border border-red-100">
                    Status: Tiket Dibatalkan / Refunded
                </p>
            @endif
        </div>

        @if($ticket->status === 'lunas')
            <div class="pt-2">
                <form action="{{ route('passenger.ticket.cancel', $ticket->order_code) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan tiket ini? Dana Anda akan dikembalikan lewat Refund otomatis dan kursi dilepas.')">
                    @csrf
                    <button type="submit" class="w-full bg-red-50 text-red-600 hover:bg-red-600 hover:text-white font-bold py-3 rounded-xl transition tracking-wide text-xs flex items-center justify-center border border-red-200">
                        <i class="fa-solid fa-rotate-left mr-2"></i> Batalkan Tiket & Ajukan Refund
                    </button>
                </form>
            </div>
        @else
            <div class="pt-2 text-center text-xs text-gray-400 font-medium italic">
                Tiket ini sudah tidak dapat di-refund karena telah hangus atau dibatalkan sebelumnya.
            </div>
        @endif

    </div>
</div>
@endsection