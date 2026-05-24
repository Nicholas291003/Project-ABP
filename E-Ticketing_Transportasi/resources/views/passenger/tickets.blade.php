@extends('layouts.passenger')
@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Tiket Perjalanan Aktif</h1>
    <p class="text-sm text-gray-500 mt-1">Daftar e-ticket resmi Anda yang siap digunakan untuk boarding.</p>
</div>

<div class="space-y-6 max-w-4xl">
    @forelse($tickets as $ticket)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col md:flex-row">
            <div class="p-6 flex-1">
                <div class="flex justify-between items-center mb-3">
                    <span class="bg-blue-100 text-primary text-xs font-bold px-2.5 py-1 rounded capitalize">{{ $ticket->schedule->transportation->jenis }}</span>
                    <span class="text-gray-400 text-xs">ID: {{ $ticket->order_code }}</span>
                </div>
                <h3 class="font-bold text-gray-800 text-lg">{{ $ticket->schedule->transportation->nama }}</h3>
                <p class="text-xs text-gray-400 mb-4">{{ \Carbon\Carbon::parse($ticket->schedule->departure_date)->format('d M Y') }}</p>
                <p class="text-sm font-medium text-gray-700">{{ $ticket->schedule->route->kota_asal }} ➔ {{ $ticket->schedule->route->kota_tujuan }}</p>
            </div>
            <div class="p-6 bg-gray-50 w-full md:w-48 flex flex-col items-center justify-center border-l border-gray-100">
                <i class="fa-solid fa-qrcode text-4xl text-gray-700 mb-3"></i>
                <a href="{{ route('passenger.ticket.show', $ticket->order_code) }}" class="w-full text-center bg-primary hover:bg-primaryDark text-white text-xs font-bold py-2 rounded-lg transition">Detail Tiket</a>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-2xl p-12 text-center border border-gray-100 shadow-sm text-gray-400">
            <i class="fa-solid fa-ticket-simple text-4xl mb-2 block"></i> Anda tidak memiliki tiket aktif.
        </div>
    @endforelse
    {{ $tickets->links() }}
</div>
@endsection